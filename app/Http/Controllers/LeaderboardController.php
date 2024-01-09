<?php

namespace App\Http\Controllers;

use App\Services\RaceCalculatorService;

class LeaderboardController extends Controller
{
    public function __construct(
        private RaceCalculatorService $raceCalculatorService
    ) {
    }

    public function index()
    {
        $leaderboard = $this->raceCalculatorService->calculateLeaderboard();
        return view('SeasonLeaderboard', compact('leaderboard'));
    }
}
