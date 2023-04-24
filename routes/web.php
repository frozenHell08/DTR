<?php

use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditProfile;
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

Route::group([
    'prefix' => 'dashboard',
    'middleware' => 'auth:web'
], function () {
    Route::post('{user}/timein', [DashboardController::class, 'timein'])->name('timein');
    Route::post('{user}/timeout', [DashboardController::class, 'timeout'])->name('timeout');
    Route::post('{user}/edit', [EditProfile::class, 'editProfile'])->name('edit');
});

Route::group([
    'middleware' => ['auth', 'token.expired'],
], function() {
    Route::get('/dashboard/{user}', [DashboardController::class, 'display'])->name('dashboard');
    Route::get('admin/dash', [AdminDashboard::class, 'showDash'])->name('admindash');
});

Route::get('/dashboard/{user}/table', [DashboardController::class, 'getTableData']);