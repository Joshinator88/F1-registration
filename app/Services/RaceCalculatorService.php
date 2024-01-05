<?php

namespace App\Services;

use App\Models\RaceResult;

class RaceCalculatorService
{
    public function recalculateScore($raceId)
    {
        // the race leaderboard has to be sorted on time. on that sorted leaderboard the points get assigned.
        // so we check the race id and limit the points to max 10 records ordered by ascending.
        $raceResults = RaceResult::where('race_id', $raceId)->limit(10)->orderBy('seconds', 'asc')->get();
        if(isset($raceResults[0])){$raceResults[0]->points = 25;}
        if(isset($raceResults[1])){$raceResults[1]->points = 18;}
        if(isset($raceResults[2])){$raceResults[2]->points = 15;}
        if(isset($raceResults[3])){$raceResults[3]->points = 12;}
        if(isset($raceResults[4])){$raceResults[4]->points = 10;}
        if(isset($raceResults[5])){$raceResults[5]->points = 8;}
        if(isset($raceResults[6])){$raceResults[6]->points = 6;}
        if(isset($raceResults[7])){$raceResults[7]->points = 4;}
        if(isset($raceResults[8])){$raceResults[8]->points = 2;}
        if(isset($raceResults[9])){$raceResults[9]->points = 1;}
        foreach ($raceResults as $key => $result) {
            // we assign 0 points if the result is not in the top 10 scores.
            if ($key >= 10) {
                $result->points = 0;
            }
            $result->save();
        }
    }

    public function calculateLeaderboard()
    {
        $leaderboards = RaceResult::select('user_id', 'points')->orderByDesc('points')->get();
        $leaderboardResult = [];

        foreach ($leaderboards as $result) {
            $leaderboardResult[$result->user->name] = ($leaderboardResult[$result->user->name] ?? 0) + $result->points;
        }

        arsort($leaderboardResult);

        return $leaderboardResult;
    }
}
