<?php

use App\Models\Trophy;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('home-edit');
Route::post('/home/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('home-edit');

Route::get('/races/{id}/result', [App\Http\Controllers\RaceResultController::class, 'index'])->name('races-id');
Route::get('/races', [App\Http\Controllers\RaceController::class, 'index'])->name('races');

Route::get('/leaderboard', [App\Http\Controllers\LeaderboardController::class, 'index'])->name('leaderboard.index');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
Route::post('/admin', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
Route::post('/addTrophies', [App\Http\Controllers\AdminController::class, 'trophyCeremony']);


Route::get('/uploadrace', [App\Http\Controllers\UploadRaceController::class, 'index'])->name('upload.index');
Route::post('/uploadrace', [App\Http\Controllers\UploadRaceController::class, 'store'])->name('upload.store');

Route::get('/search', [App\Http\Controllers\SearchController::class, 'SearchUser']);

Route::get('/users', function () {
    return view('users', [
        'users' => User::with('profile')->get()
    ]);
});

Route::get('user/{user}', function (User $user) {
    return view('visit', [
        'user' => $user,
        'trophies' => Trophy::where('user_id', $user->id)->get()
    ]);
});
