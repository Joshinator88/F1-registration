<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Race_result;
use App\Models\User;
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
        // when the user is registered he has no profile yet, so that is being created here, and then the page is refreshed so the user can access his profile page
        if (Auth::user()->profile == null) {
            $this->newUser();
            echo "<script>location.reload();</script>";
        }

        if (Auth::user()->id == 1) {
            return view('admin', [
                'results' => Race_result::with('race')->get()
                // 'results' => Race_result::where('is_valid', false)->get()
            ]);
        } else {
            return view('home', [
                'user' => Auth::user(),
            ]);
        }

        
    }
    // in this function we create a new profile for the logged in user
    private function newUser() {
        return Profile::create([
            'user_id' => Auth::user()->id,
            'followersCount' => 0
        ]);
    }

    
    private function update(Request $arr, $extension) {
        $userId = Auth::user()->id;

        // when the user updates his profile and does not want to change his profile picture, then the extension is an empty string, 
        // so when that is the case we do not want to update the profile_picture column 
        if ($extension !== ""){
            DB::table('profiles')
                ->where('user_id', $userId)
                ->update([
                    'profile_picture' => $extension,
                ]);
        }
        // here we update the profile row of the loggedin user, we alter here the: favorite_circuit, birth_date and the bio columns
        DB::table('profiles')
            ->where('user_id', $userId)
            ->update([
                'favorite_circuit' => $arr['newFavCircuit'],
                'birth_date' => $arr['newDateOfBirth'],
                'bio' => $arr['newBio'],
            ]);
// the user can update his name but it may not be an empty string, so here we only update the 
// name column in the users table when $arr['newName'] is not an empty string
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

        // when the save button is pressed then the the changes made on this page will be updated in the database
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

          $this->update($request, $extension);
          
          return view('home-edit', [
            'user' => Auth::user()
          ]);
            
            // when the quit button is pressed then the user is taken to the home page and nothing will be updated in the database
        } else if (isset($_POST['quitButton'])) {
            return  view('home', [
                'user' => Auth::user(),
            ]);
        }
        // when the user navigates to the edit page, we return the edit view
        return  view('home-edit', [
            'user' => Auth::user(),
        ]);
            
    }
}
