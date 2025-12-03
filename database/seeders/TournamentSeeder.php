<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tournaments = [
            [
                'name' => 'DAIHATSU INDONESIA MASTERS 2026',
                'title' => 'HSBC BWF World Tour Super 500',
                'prize_money' => 500000.00,
                'currency_code' => 'USD',
                'start_date' => '2026-01-20',
                'end_date' => '2026-01-25',
                'venue_name' => 'Istora Senayan, Jakarta',
                'venue_address' => 'Jl. Pintu Senayan No 1, Jakarta Pusat Indonesia ',
                'organizer' => 'Badminton Association of Indonesia / Persatuan Bulutangkis Seluruh Indonesia (PBSI)',
                'organizer_address' => 'Jl. Damai PBSI, Kelurahan/Kecamatan Cipayung Jakarta Timur 13840, Indonesia',
                'sanction' => 'Badminton World Federation',
                'official_shuttlecock' => "VICTOR – Master ACE",
                'status' => 'ACTIVE'
            ]
        ];

        foreach ($tournaments as $tournament) {
            \App\Models\Tournament::updateOrCreate(
                ['name' => $tournament['name']],
                $tournament
            );
        }
    }
}
