<?php

namespace App\Http\Controllers;

use App\Models\RaceResult;
use App\Http\Requests\StoreRace_resultRequest;
use App\Http\Requests\UpdateRace_resultRequest;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UploadRaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //here we select the race that can be driven on the current date
        $date = Carbon::now();
        $getRow = DB::table('races')
            ->whereRaw('`start`<=? and end>=?', [$date, $date])
            ->first();

        // and we pas that race object with the array
        return view('uploadrace', [
            'race' => $getRow
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // here we calculate the time in thousands so we only have to store whole numbers in the database and need only one column
        $time = intval($request['minutes']) * 60 + intval($request['seconds']) + intval($request['thousands']) / 1000;
        $userId = Auth::user()->id;
        $raceId = $request['race_id'];
        $extension = $request->controlPicture->extension();
        $allExtensions = ['jpg', 'png', 'jpeg', 'svg'];
        // check if the mime type is valid
        if (in_array(strtolower($extension), $allExtensions)) {
            $raceResult = RaceResult::where('user_id', $userId)->where('race_id', $raceId)->first();
            if ($raceResult) {
                if ($raceResult->seconds < $time) {
                    return back()->withErrors(['de tijd die je probeert te uploaden is langzamer dan je huidige tijd'])->withInput();
                }
                $raceResult->update([
                    'user_id' => $userId,
                    'seconds' => $time,
                    'is_valid' => false,
                ]);

            } else {
                $raceResult = RaceResult::create([
                    'user_id' => $userId,
                    'race_id' => $raceId,
                    'seconds' => $time,
                    'is_valid' => false,
                ]);
            }
            DB::table('race_results')
                ->where('id', $raceResult->id)
                ->update(['picture_name' => $raceResult->id . '.' . $extension]);

        return redirect(route('home'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RaceResult $race_result)
    {
        //
    }
}
