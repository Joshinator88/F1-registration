<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home', [
            'user' => Auth::user(),
 
        ]);
    }

    public function edit()
    {

        // when the submit button is pressed then the image gets moved to storage/app/profilePictures/{nameofthefile}
        if (isset($_POST['submit'])){
            move_uploaded_file($_FILES['profilePicture']['tmp_name'], storage_path('app/profilePictures/' . $_FILES['profilePicture']['name']));
        }
            return view('home-edit', [
                'user' => Auth::user(),
            ]);
        
    }
}
