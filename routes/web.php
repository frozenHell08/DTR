<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
    return view('landing');
})->name('login');

Route::post('register', [RegisterController::class, 'register'])->middleware('guest');

Route::post('login', [SessionsController::class, 'login'])->middleware('guest');
Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');

// Route::get('/dashboard/{user}', function(User $user) {
//     // $date = session('date');

//     return view ('dashboard', [
//        'user' => $user,
//     //    'date' => $date,
//     //    'datenow' => session()->get('datenow'),
//     //    'timein' => session()->get('timein'),
//     ]);
// })->name('dashboard')->middleware('auth');

Route::get('/dashboard/{user}', [DashboardController::class, 'display'])->name('dashboard')->middleware('auth');

Route::post('/dashboard/{user}/timein', [DashboardController::class, 'timein'])->name('timein')->middleware('auth');
Route::post('/dashboard/{user}/timeout', [DashboardController::class, 'timeout'])->name('timeout')->middleware('auth');