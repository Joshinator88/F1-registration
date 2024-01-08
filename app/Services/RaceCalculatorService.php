<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\RaceResult;
use Illuminate\Support\Facades\DB;

class RaceCalculatorService
{
    public function recalculateScore($raceId): void
    {
        // the race leaderboard has to be sorted on time. on that sorted leaderboard the points get assigned.
        // so we check the race id and limit the points to max 10 records ordered by ascending.
        $raceResults = RaceResult::where('race_id', $raceId)->orderBy('seconds', 'asc')->get();
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

    public function calculateLeaderboard(): array
    {
        // Query the results based on a join from race_results to users.
        // Group on user_id to retrieve summedup points from a user.
        $results = DB::table('race_results')
            ->join('users', 'race_results.user_id', '=', 'users.id')
            ->select([DB::raw('SUM(points) as sum_points'), 'users.name'])
            ->groupBy(['race_results.user_id'])
            ->orderByDesc('sum_points')
            ->get();

        $leaderboardResult = [];
        foreach ($results as $result) {
            $leaderboardResult[$result->name] = $result->sum_points;
        }

        return $leaderboardResult;
    }
}
