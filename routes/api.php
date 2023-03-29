<?php

use App\Http\Controllers\Api\DashboardControl;
use App\Http\Controllers\Api\RegistrationControl;
use App\Http\Controllers\Api\StateControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth',
    'middleware' => 'guest',
], function () {
    Route::post('register', [RegistrationControl::class, 'register']);
    Route::post('register/validate', [RegistrationControl::class, 'validateEntry']);
    Route::post('login', [StateControl::class, 'login']);
});

Route::group([
    'prefix' => 'dashboard',
    'middleware' => 'auth:api'
], function () {
    Route::post('logout', [StateControl::class, 'logout']);
    Route::post('{user}/timein', [DashboardControl::class, 'timein']);
    Route::post('{user}/timeout', [DashboardControl::class, 'timeout']);
    Route::get('{user}', [DashboardControl::class, 'selftable']);
});

Route::post('time', [DashboardControl::class, 'timeduration']);