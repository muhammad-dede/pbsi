<?php

namespace Database\Seeders;

use App\Models\SessionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sessionTypes = [
            ['code' => 'QUALIFICATION', 'name' => 'Qualification'],
            ['code' => 'MAIN_DRAW', 'name' => 'Main Draw'],
            ['code' => 'PRACTICE', 'name' => 'Practice'],
            ['code' => 'MEETING', 'name' => 'Meeting'],
        ];

        foreach ($sessionTypes as $type) {
            SessionType::updateOrCreate(
                ['code' => $type['code']],
                ['name' => $type['name']]
            );
        }
    }
}
