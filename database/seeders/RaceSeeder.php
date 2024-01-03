<?php

namespace Database\Seeders;

use App\Models\Race;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Race::create([
            'circuit' => 'Bahrain',
            'start' => '2024-02-29',
            'end' => '2024-03-02',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Saudi Arabia',
            'start' => '2024-03-03',
            'end' => '2024-03-09',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Australia',
            'start' => '2024-03-10',
            'end' => '2024-03-24',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Japan',
            'start' => '2024-03-25',
            'end' => '2024-04-07',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'China',
            'start' => '2024-04-08',
            'end' => '2024-04-21',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Miami',
            'start' => '2024-04-22',
            'end' => '2024-05-05',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Imola',
            'start' => '2024-05-06',
            'end' => '2024-05-19',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Monaco',
            'start' => '2024-05-20',
            'end' => '2024-05-26',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Canada',
            'start' => '2024-05-27',
            'end' => '2024-06-09',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Spain',
            'start' => '2024-06-10',
            'end' => '2024-06-23',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Austria',
            'start' => '2024-06-24',
            'end' => '2024-06-30',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'United Kingdom',
            'start' => '2024-07-01',
            'end' => '2024-07-07',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Hungary',
            'start' => '2024-07-08',
            'end' => '2024-07-21',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Belgium',
            'start' => '2024-07-22',
            'end' => '2024-07-28',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Netherlands',
            'start' => '2024-07-29',
            'end' => '2024-08-25',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Italy',
            'start' => '2024-08-26',
            'end' => '2024-09-01',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Azerbaijan',
            'start' => '2024-09-02',
            'end' => '2024-09-15',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Singapore',
            'start' => '2024-09-16',
            'end' => '2024-09-22',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'USA',
            'start' => '2024-09-23',
            'end' => '2024-10-20',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Mexico',
            'start' => '2024-10-21',
            'end' => '2024-10-27',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Brazil',
            'start' => '2024-10-28',
            'end' => '2024-11-03',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Las Vegas',
            'start' => '2024-11-04',
            'end' => '2024-11-23',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Qatar',
            'start' => '2024-11-24',
            'end' => '2024-12-01',
            'season' => 2024
        ]);
        Race::create([
            'circuit' => 'Abu Dhabi',
            'start' => '2024-12-02',
            'end' => '2024-12-08',
            'season' => 2024
        ]);
    }
}
