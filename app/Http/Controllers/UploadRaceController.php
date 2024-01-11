<?php

namespace App\Http\Controllers;

use App\Models\RaceResult;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadRaceController extends Controller
{
    public function index()
    {
        //here we select the race that can be driven on the current date
        // $date = Carbon::now();
        $date = "2024-02-29";
        $getRow = DB::table('races')
            ->whereRaw('`start`<=? and `end`>=?', [$date, $date])
            ->first();

        // and we pas that race object with the array
        return view('uploadrace', [
            'race' => $getRow
        ]);
    }

    public function store(Request $request)
    {
        // here we calculate the time in thousands so we only have to store whole numbers in the database and need only one column
        $time = intval($request['minutes']) * 60 + intval($request['seconds']) + intval($request['thousands']) / 1000;
        $userId = Auth::user()->id;
        $raceId = $request['race_id'];
        $extension = $request->controlPicture->extension();
        $allExtensions = ['jpg', 'png', 'jpeg', 'svg'];

        // validate if file mime type is valid
        if (!in_array(strtolower($extension), $allExtensions)) {
            return $this->redirectBackWithErrorMimeTypeInvalid();
        }

        // When the race result is already existant we want to update it to prevent double records from the same user.
        $raceResult = RaceResult::create([
            'user_id' => $userId,
            'race_id' => $raceId,
            'seconds' => $time,
            'is_valid' => false,
        ]);

        $this->uploadRaceResultProof($raceResult, $extension, $request);

        return redirect(route('home'));
    }

    private function redirectBackWithErrorMimeTypeInvalid(): RedirectResponse
    {
        $now = Carbon::now();
        $getRow = DB::table('races')
            ->whereRaw('`start`<=? and end>=?', [$now, $now])
            ->first();

        // and we pas that race object with the array
        return back()->withErrors([
            'race' => $getRow,
            'error' => "you can only upload: 'jpg', 'png', 'jpeg', 'svg'"
        ])->withInput();
    }

    /**
     * Store the race result into its own folder and ID so that we are able to retrieve it by id later.
     */
    private function uploadRaceResultProof($raceResult, $extension, Request $request): void
    {
        $pictureName = 'raceResultProof/' . $raceResult->id . '.' . $extension;
        Storage::disk('local')
            ->put($pictureName, $request->file('controlPicture')->getContent());

        DB::table('race_results')
            ->where('id', $raceResult->id)
            ->update(['picture_name' => $raceResult->id . '.' . $extension]);
    }
}
