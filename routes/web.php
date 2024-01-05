<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


Route::get('/uploadrace', [App\Http\Controllers\UploadRaceController::class, 'index'])->name('upload.index');
Route::post('/uploadrace', [App\Http\Controllers\UploadRaceController::class, 'store'])->name('upload.store');

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
Route::post('/admin', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
