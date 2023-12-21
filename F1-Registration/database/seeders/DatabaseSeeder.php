<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Race;
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
        // User::factory(5)->create();

        Race::create([
            'circuit' => 'Sakhir',
            'start' => '2024-02-14',
            'end' => '2024-03-06',
            'season' => 2024
        ]);

        Race::create([
            'circuit' => 'Jeddah',
            'start' => '2024-03-07',
            'end' => '2024-03-21',
            'season' => 2024
        ]);

        Race::create([
            'circuit' => 'Melbourne',
            'start' => '2024-03-22',
            'end' => '2024-04-04',
            'season' => 2024
        ]);


        
    }
}
