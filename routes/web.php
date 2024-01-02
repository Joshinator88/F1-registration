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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('home-edit');
Route::get('races',);
Route::get('/circuit-leaderboard', [\App\Http\Controllers\CircuitLeaderboardController::class, 'index'])->name('circuit-leaderboard');
Route::get('/uploadrace', [App\Http\Controllers\RaceResultController::class, 'index']);
Route::post('/uploadrace', [App\Http\Controllers\RaceResultController::class, 'store']);
