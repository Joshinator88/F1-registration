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

    public function update(Request $request) {
        if (isset($request['goedgekeurd'])) {
            DB::table('race_results')->where('id', $request['id'])->update([
                'is_valid' => true
            ]);
        } else if (isset($request['afgekeurd'])) {
            DB::table('race_results')->where('id', $request['id'])->delete();
        }
        return view('admin', [
            'results' => Race_result::where('is_valid', false)->with('race')->get()
        ]);

    }
    
}
