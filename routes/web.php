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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('home-edit');

Route::post('/home/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('home-edit');

Route::get('/uploadrace', [App\Http\Controllers\RaceResultController::class, 'index']);

Route::post('/uploadrace', [App\Http\Controllers\RaceResultController::class, 'store']);

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index']);

Route::post('/admin', [App\Http\Controllers\AdminController::class, 'update']);
