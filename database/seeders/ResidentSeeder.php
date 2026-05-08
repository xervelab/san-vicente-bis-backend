<?php

namespace Database\Seeders;

use App\Models\Resident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResidentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the residents table.
     */
    public function run(): void
    {
        Resident::factory()->count(20)->create();

        Resident::firstOrCreate(
            ['name' => 'Juan Dela Cruz', 'purok' => 'Purok 1'],
            [
                'age' => 42,
                'status' => 'Active',
            ]
        );
    }
}
