<?php

namespace Database\Seeders;

use App\Models\Round;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rounds = [
            ['code' => 'WINNER', 'name' => 'Winner'],
            ['code' => 'RUNNER_UP', 'name' => 'Runner-up'],
            ['code' => 'SEMIFINALIST', 'name' => 'Semifinalist'],
            ['code' => 'QUARTERFINALIST', 'name' => 'Quarterfinalist'],
            ['code' => 'LAST_16', 'name' => 'Last 16'],
        ];

        foreach ($rounds as $round) {
            Round::updateOrCreate(
                ['code' => $round['code']],
                ['name' => $round['name']]
            );
        }
    }
}
