<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Models\RaceResult;
use Illuminate\Http\Request;

class RaceResultController extends Controller
{
    public function index($id)
    {
        // Here we find the race and pass it to the view
        $race = Race::find($id);
        // i wanted to get the race results and order them from highest to lowest amount of points,
        // i also chose to limit the amount of records to 10 because the lowest amount of points is assigned to the 10th place in f1.
        $raceResults = RaceResult::where('race_id', $id)->limit(10)->orderBy('points', 'desc')->get();
        return view('RaceResult', compact('raceResults', 'race'));
    }
}
