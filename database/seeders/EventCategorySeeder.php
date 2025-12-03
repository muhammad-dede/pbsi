<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventCategories = [
            ['code' => 'MS',  'name' => "Men's Singles"],
            ['code' => 'WS',  'name' => "Women's Singles"],
            ['code' => 'MD',  'name' => "Men's Doubles"],
            ['code' => 'WD',  'name' => "Women's Doubles"],
            ['code' => 'XD',  'name' => "Mixed Doubles"],
        ];

        foreach ($eventCategories as $category) {
            EventCategory::updateOrCreate(
                ['code' => $category['code']],
                ['name' => $category['name']]
            );
        }
    }
}
