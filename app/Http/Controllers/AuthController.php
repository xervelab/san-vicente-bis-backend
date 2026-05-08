<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $plainToken = Str::random(60);
        $user->forceFill([
            'api_token' => hash('sha256', $plainToken),
        ])->save();

        return response()->json([
            'token' => $plainToken,
            'token_type' => 'Bearer',
            'user' => $user->only(['id', 'name', 'email', 'role']) + ['role_name' => $user->role_name],
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $plainToken = Str::random(60);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => hash('sha256', $plainToken),
            'role' => User::ROLE_RESIDENT, // Default role for new registrations
        ]);

        return response()->json([
            'token' => $plainToken,
            'token_type' => 'Bearer',
            'user' => $user->only(['id', 'name', 'email', 'role']) + ['role_name' => $user->role_name],
        ], 201);
    }

    public function logout(Request $request)
    {
        $user = $this->userFromRequest($request);

        if (! $user) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $user->forceFill(['api_token' => null])->save();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Password reset link sent'])
            : response()->json(['message' => 'Unable to send password reset link'], 422);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                    'api_token' => null,
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successful'])
            : response()->json(['message' => trans($status)], 422);
    }

    protected function userFromRequest(Request $request): ?User
    {
        $token = $request->bearerToken() ?? $request->input('token');

        if (! $token) {
            return null;
        }

        return User::where('api_token', hash('sha256', $token))->first();
    }
}
