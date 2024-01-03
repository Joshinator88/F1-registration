<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Race;
use App\Models\RaceResult;
use App\Models\User;
use Database\Factories\RaceFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(15)->create();

        Race::create([
            'circuit' => 'Bahrain',
            'start' => '2024-02-14',
            'end' => '2024-03-06',
            'season' => 2024
        ]);

        Race::create([
            'circuit' => 'Saudi_arabia',
            'start' => '2024-03-07',
            'end' => '2024-03-21',
            'season' => 2024
        ]);

        Race::create([
            'circuit' => 'Australia',
            'start' => '2024-03-22',
            'end' => '2024-04-04',
            'season' => 2024
        ]);

        RaceResult::create([
            'user_id' => '2',
            'race_id' => '2',
            'seconds' => '84.123',
            'points' => '10',
            'is_valid' => '0',
        ]);

        RaceResult::create([
            'user_id' => '3',
            'race_id' => '2',
            'seconds' => '65.222',
            'points' => '15',
            'is_valid' => '0',
        ]);

        RaceResult::create([
            'user_id' => '4',
            'race_id' => '2',
            'seconds' => '68.985',
            'points' => '12',
            'is_valid' => '0',
        ]);

    }
}
