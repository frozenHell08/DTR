<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
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
});

Route::post('register', [RegisterController::class, 'register'])->middleware('guest');

Route::post('login', [SessionsController::class, 'login'])->middleware('guest');
Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');

Route::get('/dashboard/{user}', function(User $user) {
    return view ('dashboard', [
        'user' => $user
    ]);
})->name('dashboard')->middleware('auth');

// Route::post('/dashboard/{user}/timein', [DashboardController::class, 'timein'])->name('timein')->middleware('auth');
// Route::post('/dashboard/{user}/timeout', [DashboardController::class, 'timeout'])->name('timeout')->middleware('auth');

Route::group([
    'prefix' => 'dashboard',
    'middleware' => 'auth:web'
], function () {
    Route::post('{user}/timein', [DashboardController::class, 'timein'])->name('timein');
    Route::post('{user}/timeout', [DashboardController::class, 'timeout'])->name('timeout');
});