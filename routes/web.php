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

Route::get('/races/{id}/result', [App\Http\Controllers\RaceResultController::class, 'index'])->name('races-id');
Route::get('races', [App\Http\Controllers\RaceController::class, 'index'])->name('races');


Route::get('/uploadrace', [App\Http\Controllers\UploadRaceController::class, 'index']);
Route::post('/uploadrace', [App\Http\Controllers\UploadRaceController::class, 'store']);
