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
use Illuminate\Support\Facades\File;
use Illuminate\Validation\UnauthorizedException;

class AdminController extends Controller
{
    // use dependency injection to instanciate class dynamically
    //now we can use the RaceCalculatorService anywhere we need
    public function __construct(private RaceCalculatorService $raceCalculatorService)
    {
    }

    public function index()
    {
        if (Auth::user()->admin === true) {
            $date = "2024-04-04";
            $races = DB::table('races')
            ->whereRaw('`end`<?', [Carbon::now()])
            ->get();
            $raceResults = RaceResult::where('is_valid', false)->with('race')->get();

            return view('admin', compact(['raceResults', 'races']));
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
            $raceResults = $raceResultsRaw->unique('user_id')->take(3);
            // check if there are reccords of trophies in the database, if so update them with new data otherwise create new entries
            if (Trophy::where('race_id', $request['raceId'])->exists()) {

                // update the gold medalist
                Trophy::where('race_id', $request['raceId'])->where('trophy', "🥇")->update([
                    'user_id' => $raceResults[0]->user_id,
                ]);
                // update the silver medalist
                Trophy::where('race_id', $request['raceId'])->where('trophy', "🥈")->update([
                    'user_id' => $raceResults[1]->user_id,
                ]);
                // update the bronze medalist
                Trophy::where('race_id', $request['raceId'])->where('trophy', "🥉")->update([
                    'user_id' => $raceResults[2]->user_id,
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
                    'trophy' => "🥉",
                ]);
            }
            // when the delete button is pressed we will delete all the trophies of this race
        } else if (isset($request['removeTrophies'])) {
                Trophy::where('race_id', $request['raceId'])->delete();

        }
        // when all te trophies are devided, deleted or updated, the user gets directed back to the admin page
        return redirect('admin');
//            view('admin', [
//            'results' => RaceResult::where('is_valid', false)->with('race')->get(),
//            'races' => DB::table('races')->whereRaw('`end`<?', [Carbon::now()])->get()
//        ]);

    }

    /**
     * in this method we update the race_result based on what the input of the admin is
     */
    public function update(Request $request)
    {
        // check what button is pressed and then make a raceresult valid or delete it based on the input
        if (isset($request['goedgekeurd'])) {
            DB::table('race_results')->where('id', $request['id'])->update([
                'is_valid' => true
            ]);
            $raceResult = RaceResult::findOrFail($request['id']);
            $this->raceCalculatorService->recalculateScore($raceResult->race_id);
        } else if (isset($request['afgekeurd'])) {
            DB::table('race_results')->where('id', $request['id'])->delete();
        }

        // when update method is called then we have no need anymore for the pictures so we delete them
        if (File::exists('/controlePictures/' . $request['picture_name'])) {
            File::delete('/controlePictures/' . $request['picture_name']);
        }



        return redirect(route('admin'))->with(['success' => 'successfully approved']);
    }
}
