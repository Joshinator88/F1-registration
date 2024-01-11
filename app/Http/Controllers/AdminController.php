<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Services\RaceCalculatorService;
use Illuminate\Support\Facades\Auth;
use App\Models\RaceResult;
use App\Models\Trophy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;

class AdminController extends Controller
{
    // use dependency injection to instanciate class dynamically
    //now we can use the RaceCalculatorService anywhere we need
    public function __construct(private RaceCalculatorService $raceCalculatorService)
    {
    }
    // private $date = Carbon::now();
    private $date = "2024-03-29";

    public function index()
    {
        if (Auth::user()->admin === true) {
            $raceResults = RaceResult::where('is_valid', false)->with('race')->get();

            return view('admin', compact('raceResults'));
        }

        throw new UnauthorizedException('You cannot view the administrator page.');
    }

    /**
     * a function hand out trophies if they finnished first second or third on a particular circuit.
     */
    public function trophyCeremony(Request $request){
        if (isset($request['giveTrophies'])) {
            // only look at the validated races
            // get the top three performers on this circuit and hand them the trophies
            $raceResultsRaw = RaceResult::where('is_valid', true)->orderBy('seconds', 'asc')->get();
            $raceResults = $raceResultsRaw->unique('user_id')->take(3)->get();
            // check if there are reccords of trophies in the database, if so update them with new data otherwise create new entries
            if (Trophy::where('race_id', $request['raceId'])->exists()) {

                Trophy::where('race_id', $request['raceId'])->update([
                    'user_id' => $raceResults[0]->user_id,
                    'trophy' => "🥇",
                ]);
                Trophy::where('race_id', $request['raceId'])->update([
                    'user_id' => $raceResults[1]->user_id,
                    'trophy' => "🥈",
                ]);
                Trophy::where('race_id', $request['raceId'])->update([
                    'user_id' => $raceResults[2]->user_id,
                    'trophy' => "🥉 ",
                ]);
            } else {

                Trophy::create([
                    'user_id' => $raceResults[0]->user_id,
                    'race_id' => $request['raceId'],
                    'trophy' => "🥇",
                ]);
                Trophy::create([
                    'user_id' => $raceResults[1]->user_id,
                    'race_id' => $request['raceId'],
                    'trophy' => "🥈",
                ]);
                Trophy::create([
                    'user_id' => $raceResults[2]->user_id,
                    'race_id' => $request['raceId'],
                    'trophy' => "🥉 ",
                ]);
            }
        } else if (isset($request['removeTrophies'])) {
                Trophy::where('race_id', $request['raceId'])->delete();

        }
        return view('admin', [
            'results' => RaceResult::where('is_valid', false)->with('race')->get(),
            'races' => DB::table('races')->whereRaw('`end`<?', [$this->date])->get()
        ]);

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

        return redirect(route('admin'))->with(['success' => 'successfully approved']);
    }
}
