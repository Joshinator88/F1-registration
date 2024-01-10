<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\RaceResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RaceResultController extends Controller
{
    public function index($id)
    {
        // Here we find the race and pass it to the view
        $race = Race::find($id);
        // i wanted to get the race results and order them from highest to lowest amount of points,
        // i also chose to limit the amount of records to 10 because the lowest amount of points is assigned to the 10th place in f1.

        $raceResults = RaceResult::where('race_id', $id)
            ->where('is_valid', true)
            ->orderBy('seconds')
            ->get();
        $raceResults = $raceResults->unique('user_id')->values()->take(10);

        // Get all the race results of the logged in user and send encode it as json so that we can use it in javascript and make a graph
        $raceResultsUser = json_encode(DB::table('race_results')
            ->where('race_id', $race->id)
            ->where('user_id', Auth::user()->id)
            ->orderByDesc('created_at')
            ->get(['created_at', 'seconds']));
        return view('RaceResult', compact('raceResults', 'race', 'raceResultsUser'));
    }
}
