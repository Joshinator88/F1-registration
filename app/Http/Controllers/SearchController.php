<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //

    public function searchUser(Request $request) {
        return view('found-users', [
            // 'users' => User::search($request->search)->get()
            // 'users' => User::with('profile')->where('name', 'LIKE', '%' . $request->search . '%')->get()
            'users' => DB::table('users')
                ->where('name', 'LIKE', "%{$request->search}%")
                ->get()
        ]);
        
    }
}
