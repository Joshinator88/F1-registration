<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\RaceResult;
use Illuminate\Support\Facades\DB;

class RaceCalculatorService
{
    /**
     * this method will give each user the points they deserved based on their times they have driven
     */
    public function recalculateScore($raceId): void
    {
        // Mysql has a standard that a `GROUP BY` is executed before `ORDER BY`,
        // to resolve that issue we now  `GROUP BY` after `ORDER BY` with the laravel collection method unique.
        // This method picks the first record that it encounters per unique key. In our case the user_id.
        // Because we ordered the seconds query it will now pick the quickest record per user_id.
        // See this page for more info: https://laravel.com/docs/10.x/collections#method-unique
        $raceResults = RaceResult::where('race_id', $raceId)
            ->orderBy('seconds')
            ->get();
        $raceResults = $raceResults->unique('user_id')->values();
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
        $excludedRaceIds = [];
        foreach ($raceResults as $key => $result) {
            // we assign 0 points if the result is not in the top 10 scores.
            if ($key >= 10) {
                break;
            }
            $excludedRaceIds[] = $result->id;
            $result->save();
        }

        DB::table('race_results')
            ->whereNotIn('id', $excludedRaceIds)
            ->where('race_id', $raceId)
            ->update(['points' => 0]);
    }

    /**
     * returns the leaderboard based on the amount of points the users have
     */
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
