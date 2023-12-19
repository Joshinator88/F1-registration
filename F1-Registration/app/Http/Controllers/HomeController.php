<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        if (Auth::user()->profile == null) {
            $this->newUser();
            echo "<script>location.reload();</script>";
        }

        return view('home', [
            'user' => Auth::user(),
 
        ]);
    }
    private function newUser() {
        return Profile::create([
            'user_id' => Auth::user()->id,
            'followersCount' => 0
        ]);
    }

    
    protected function create(Request $arr, $extension) {
        $userId = Auth::user()->id;
       
        if ($extension !== ""){
            DB::table('profiles')
                ->where('user_id', $userId)
                ->update([
                    'profile_picture' => $extension,
                ]);
        }
        DB::table('profiles')
            ->where('user_id', $userId)
            ->update([
                'favorite_circuit' => $arr['newFavCircuit'],
                'birth_date' => $arr['newDateOfBirth'],
                'bio' => $arr['newBio'],
            ]);

        if ($arr['newName'] !== "") {
            DB::table('users')
                ->where('id', $userId)
                ->update([
                    'name' => $arr['newName']
                ]);
        }
           
            
    }
    

    public function edit(Request $request)
    {

        // when the submit button is pressed then the image gets moved to storage/app/profilePictures/{nameofthefile}
        if (isset($_POST['saveButton'])){
            
            $ogExtension = "";
            $extension = "";
            
        //    We are storing the extension in the ogExtension variable to later give the name and check if it is a supported mime
            if ($request->profilePicture !== null){
                $ogExtension = $request->profilePicture->extension();
                // storing all supported extensions in an array to check if the mime stored in ogExtension matches one in the array
                $allExtensions = ['jpg', 'png', 'jpeg', 'svg'];

                // check if mime is valid
                if (in_array(strtolower($ogExtension), $allExtensions)) {
                    $extension = $ogExtension;

                    // making a name for the file based on user id
                    $nameFile = Auth::user()->id . "profile." . $ogExtension;     
                    // taking the uploaded file and storing it in: "public/profilePictures under the predetermined name
                    move_uploaded_file($_FILES['profilePicture']['tmp_name'], 'profilePictures/' . $nameFile);
                    // var_dump($request['newEmail']);
                }
            }

          $this->create($request, $extension);
          $loggedinUser = Auth::user();
          if ($loggedinUser->profile == null) {

          }
          return view('home-edit', [
            'user' => $loggedinUser
          ]);
            
            
        } else if (isset($_POST['resetButton'])) {
            return  view('home', [
                'user' => Auth::user(),
            ]);
        }
        return  view('home-edit', [
            'user' => Auth::user(),
        ]);
            
    }
}
