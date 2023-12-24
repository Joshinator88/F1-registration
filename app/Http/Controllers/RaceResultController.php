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

class RaceResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //here we select the race that can be driven on the current date
        $date = '2024-03-18';
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
        if (in_array(strtolower($extension), $allExtensions)) {
            $race = Race_result::create([
                'user_id' => $user,
                'race_id' => $request['race_id'],
                'seconds' => $time,
                'is_valid' => false,
            ]);
    
            DB::table('race_results')
                ->where('id', $race->id)
                ->update(['picture_name' => $race->id . '.' . $extension]);

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
