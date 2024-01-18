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
        $date = Carbon::now();
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
        // if the mime is valid then we create a reccord of this result in the db
        $raceResult = RaceResult::create([
            'user_id' => $userId,
            'race_id' => $raceId,
            'seconds' => $time,
            'is_valid' => false,
        ]);
        // then we give the picture the name of the id of its reccord in the database
        $name = $raceResult->id . "." . $extension;

        // we save the picture on the server in the folder: 'controlPictures'
        $picturePath = 'controlPictures/' . $name;
        Storage::disk('local')
            ->put($picturePath, $request->file('controlPicture')->getContent());

        // and at last we also save that name in the database
        RaceResult::where('id', $raceResult->id)->update([
            'picture_name' => $name
        ]);

        return redirect(route('home'));
    }

    /**
     * method for redirecting back to the upload page where the user is thrown a message the file he uploaded is not compatible
     */
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


}
