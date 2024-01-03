<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Race_result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function index() {
        if (Auth::user()->id == 1) {
            return view('admin', [
                'results' => Race_result::where('is_valid', false)->with('race')->get()
            ]);
        } else {
            return view('home');
        }
    }

    public function update(Request $request)
    {
        if (isset($request['goedgekeurd'])) {
            DB::table('race_results')->where('id', $request['id'])->update([
                'is_valid' => true
            ]);
            $raceResult = Race_result::findOrFail($request['id']);
            $this->recalculateScore($raceResult->race_id);
        } else if (isset($request['afgekeurd'])) {
            DB::table('race_results')->where('id', $request['id'])->delete();
        }
        return view('admin', [
            'results' => Race_result::where('is_valid', false)->with('race')->get()
        ]);

    }
    private function recalculateScore($id)
    {
        // the race leaderboard has to be sorted on time. on that sorted leaderboard the points get assigned.
        // so we check the race id and limit the points to max 10 records ordered by ascending.
        $raceResults = Race_result::where('race_id', $id)->limit(10)->orderBy('seconds', 'asc')->get();
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
}
