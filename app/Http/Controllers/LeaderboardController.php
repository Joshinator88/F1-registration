<?php

namespace App\Http\Controllers;

use App\Models\RaceResult;
use App\Services\RaceCalculatorService;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function __construct(private RaceCalculatorService $raceCalculatorService)
    {
    }

    public function index()
    {
        $leaderboard = $this->raceCalculatorService->calculateLeaderboard();
        return view('seasonleaderboard', ['leaderboard' => $leaderboard]);
    }
}
