<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //
/**
 * making a method for finding a user based on what the logged in user has put in the search bar
 */
    public function searchUser(Request $request) {
        return view('users', [
            'users' => User::with('profile')->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                ->get()
        ]);
        
    }
}
