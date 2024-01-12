<?php

namespace App\Http\Controllers;

use App\Services\RaceCalculatorService;

class LeaderboardController extends Controller
{
    public function __construct(
        // create an instance of the raceCalculatorService so that we can use its methods
        private RaceCalculatorService $raceCalculatorService
    ) {
    }

    public function index()
    {
        $leaderboard = $this->raceCalculatorService->calculateLeaderboard();
        return view('SeasonLeaderboard', compact('leaderboard'));
    }
}
