<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;
use Illuminate\Http\Request;
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

    public function edit(Request $request)
    {

        // when the submit button is pressed then the image gets moved to storage/app/profilePictures/{nameofthefile}
        if (isset($_POST['submit'])){
        //    We are storing the extension in the ogExtension variable to later give the name and check if it is a supported mime
            $ogExtension = $request->profilePicture->extension();
            // storing all supported extensions in an array to check if the mime stored in ogExtension matches one in the array
            $allExtensions = ['jpg', 'png', 'jpeg', 'svg'];

            // check if mime is valid
            if (in_array(strtolower($ogExtension), $allExtensions)) {

                // making a name for the file based on user id
                $nameFile = Auth::user()->id . "profile." . $ogExtension;     
                // taking the uploaded file and storing it in: "storage/app/profilePictures under the predetermined name
                move_uploaded_file($_FILES['profilePicture']['tmp_name'], storage_path('app/profilePictures/' . $nameFile));
            }

        }
            return view('home-edit', [
                'user' => Auth::user(),
            ]);
        
    }
}
