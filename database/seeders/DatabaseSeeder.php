<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo accounts
        foreach (User::DEMO_ACCOUNTS as $email => $account) {
            User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $account['name'],
                    'role' => $account['role'],
                    'password' => bcrypt('password'), // Default password for demo accounts
                ]
            );
        }

        // Create additional test user if needed
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'role' => User::ROLE_RESIDENT,
                'password' => bcrypt('password'),
            ]
        );
    }
}
