<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CircuitLeaderboardController extends Controller
{
    public function index()
    {
        return view('circuit-leaderboard');
    }
}
