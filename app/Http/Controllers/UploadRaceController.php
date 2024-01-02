<?php

namespace App\Http\Controllers;

use App\Models\Race_result;
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
        // here we calculate the time in thousants so we only have to store whole numbers in the database and need only one column
        $time = intval($request['minutes']) * 60 + intval($request['seconds']) + intval($request['thousands']) / 1000;
        $user = Auth::user()->id;
        $extension = $request->controlPicture->extension();
        $allExtensions = ['jpg', 'png', 'jpeg', 'svg'];
        // check if the mime type is valid
        if (in_array(strtolower($extension), $allExtensions)) {
            $raceResult = Race_result::create([
                'user_id' => $user,
                'race_id' => $request['race_id'],
                'seconds' => $time,
                'is_valid' => false,
            ]);

            DB::table('race_results')
                ->where('id', $raceResult->id)
                ->update(['picture_name' => $raceResult->id . '.' . $extension]);
            $this->recalculateScore($raceResult->race_id);
            return view('home', [
                'user' => Auth::user()
            ]);
        } else {
            $date = '2024-03-18';
            $getRow = DB::table('races')
                ->whereRaw('`start`<=? and end>=?', [$date, $date])
                ->first();

            // and we pas that race object with the array
            return view('uploadrace', [
                'race' => $getRow,
                'error' => "you can only upload: 'jpg', 'png', 'jpeg', 'svg'"
            ]);
        }
    }

    private function recalculateScore($id)
    {
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
            if ($key >= 10) {
                $result->points = 0;
            }
            $result->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Race_result $race_result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Race_result $race_result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRace_resultRequest $request, Race_result $race_result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Race_result $race_result)
    {
        //
    }
}
