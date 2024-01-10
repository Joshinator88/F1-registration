<?php

namespace App\Http\Controllers;

use App\Services\RaceCalculatorService;
use Illuminate\Support\Facades\Auth;
use App\Models\RaceResult;
use App\Models\Trophy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // use dependency injection to instanciate class dynamically
    //now we can use the RaceCalculatorService anywhere we need
    public function __construct(private RaceCalculatorService $raceCalculatorService)
    {
    }

    //
    public function index()
    {
        if (Auth::user()->id == 1) {
            return view('admin', [
                'results' => RaceResult::where('is_valid', false)->with('race')->get()
            ]);
        } else {
            return view('home');
        }
    }

    /**
     * a function hand out trophies if they finnished first second or third on a particular circuit.
     */
    private function trophyCeremony($race_id){
        $race = DB::table('race')->where('id', $race_id)->first();
        
        // check if the race has ended
        if ($race->end < Carbon::now()) {
            // check if all races are evaluated by the admin
            if (DB::table('race_result')->where('race_id', $race_id)->where('is_valid', false)->get() === null) {
                // get the top three performers on this circuit and hand them the trophies
                $raceResults = RaceResult::where('race_id', $race_id)->orderBy('seconds', 'asc')->take(3)->get();
                Trophy::create([
                    'user_id' => $raceResults[0]->user_id,
                    'race_id' => $race_id,
                    'trophy' => "🥇",
                ]);
                Trophy::create([
                    'user_id' => $raceResults[1]->user_id,
                    'race_id' => $race_id,
                    'trophy' => "🥈",
                ]);
                Trophy::create([
                    'user_id' => $raceResults[2]->user_id,
                    'race_id' => $race_id,
                    'trophy' => "🥉",
                ]);
            }
        }
    }

    /**
     * in this method we update the race_result based on what the input of the admin is
     */
    public function update(Request $request)
    {
        if (isset($request['goedgekeurd'])) {
            DB::table('race_results')->where('id', $request['id'])->update([
                'is_valid' => true
            ]);
            $raceResult = RaceResult::findOrFail($request['id']);
            $this->raceCalculatorService->recalculateScore($raceResult->race_id);
        } else if (isset($request['afgekeurd'])) {
            DB::table('race_results')->where('id', $request['id'])->delete();
        }
// call the function to hand out trophies to the top 3 racers
        $this->trophyCeremony($request['race_id']);
        return view('admin', [
            'results' => RaceResult::where('is_valid', false)->with('race')->get()
        ]);
    }
}
