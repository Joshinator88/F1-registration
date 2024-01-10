<?php

namespace App\Http\Controllers;

use App\Services\RaceCalculatorService;
use Illuminate\Support\Facades\Auth;
use App\Models\RaceResult;
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
        if (Auth::user()->admin === true) {
            $raceResults = RaceResult::where('is_valid', false)->with('race')->get();

            return view('admin', compact('raceResults'));
        }
    }

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
        return view('admin', [
            'results' => RaceResult::where('is_valid', false)->with('race')->get()
        ]);
    }
}
