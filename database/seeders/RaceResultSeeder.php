<?php

namespace Database\Seeders;

use App\Models\Race;
use App\Models\RaceResult;
use App\Models\User;
use App\Services\RaceCalculatorService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RaceResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var RaceCalculatorService $raceCalculatorService */
        $raceCalculatorService = app(RaceCalculatorService::class);
        Race::all();
        $races = Race::all();
        $users = User::all();
        foreach ($users as $user) {
            foreach ($races as $race) {
                RaceResult::factory(12)->create(['race_id' => $race->id, 'user_id' => $user->id]);
                $raceCalculatorService->recalculateScore($race->id);
            }
        }
    }
}
