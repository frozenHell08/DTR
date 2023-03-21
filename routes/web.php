<?php

use App\Http\Controllers\DashboardController;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
Route::group([
    'prefix' => 'user',
], function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [RegisterController::class, 'login']);
    Route::get('/dashboard/{id}', [DashboardController::class, 'show_details']);
});
=======
Route::post('register', [RegisterController::class, 'register'])->middleware('guest');

Route::post('login', [SessionsController::class, 'login'])->middleware('guest');
Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');

Route::get('/dashboard/{id}', function($id) {
    return view ('dashboard', [
        // 'user' => $id
    ]);
})->middleware('auth');
>>>>>>> Stashed changes
