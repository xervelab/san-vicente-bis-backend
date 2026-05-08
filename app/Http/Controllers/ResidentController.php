<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index()
    {
        return response()->json(Resident::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:0'],
            'purok' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:100'],
        ]);

        $resident = Resident::create($data);

        return response()->json($resident, 201);
    }

    public function show(Resident $resident)
    {
        return response()->json($resident);
    }

    public function update(Request $request, Resident $resident)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'age' => ['sometimes', 'required', 'integer', 'min:0'],
            'purok' => ['sometimes', 'required', 'string', 'max:255'],
            'status' => ['sometimes', 'required', 'string', 'max:100'],
        ]);

        $resident->update($data);

        return response()->json($resident);
    }

    public function destroy(Resident $resident)
    {
        $resident->delete();

        return response()->json(['message' => 'Resident deleted successfully']);
    }
}
