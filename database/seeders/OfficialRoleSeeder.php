<?php

namespace Database\Seeders;

use App\Models\OfficialRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficialRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $officialRoles = [
            ['code' => 'REFEREE',  'name' => 'Referee'],
            ['code' => 'DEPUTY_REFEREE',  'name' => 'Deputy Referee'],
            ['code' => 'LOCAL_DEPUTY_REFEREE',  'name' => 'Local Deputy Referee'],
            ['code' => 'TOURNAMENT_DIRECTOR', 'name' => 'Tournament Director'],
        ];

        foreach ($officialRoles as $role) {
            OfficialRole::updateOrCreate(
                ['code' => $role['code']],
                ['name' => $role['name']]
            );
        }
    }
}
