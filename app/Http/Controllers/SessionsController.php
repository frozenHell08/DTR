<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class SessionsController extends Controller
{
    public function login() {
        $forminput = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // if (! $token = auth()->guard('api')->attempt($forminput)) {
        //     JWTAuth::refresh();
            
        //     return response()->json([
        //         'success' => false,
        //         'status' => 'failed',
        //         'message' => 'Unauthorized login'
        //     ], 404);
        // }
        
        // if (auth()->guard('api')->user()->is_admin) {
        //     return response()->json([
        //         'success' => true,
        //         'type' => 'admin',
        //     ]);    
        // }

        // return response()->json([
        //     'success' => true,
        //     'type' => 'user',
        // ]);


        // return $this->respondWithToken($token);


        // if (! $token = auth()->guard('api')->attempt($forminput)) {
        //     JWTAuth::refresh();

        //     throw ValidationException::withMessages([
        //         'email' => 'Provided credentials are not valid.'
        //     ]);
        // }

        // if (auth()->guard('api')->user()->is_admin) {
        //     return redirect()->intended(route('admindash'))->with('success', 'Admin!');
        // }


        if (! auth()->attempt($forminput)) {
            throw ValidationException::withMessages([
                'email' => 'Provided credentials are not valid.'
            ]);
        }
        
        session()->regenerate();

        if (auth()->user()->is_admin) {
            return redirect()->intended(route('admindash'))->with('success', 'Admin!');
        }

        return redirect()->intended(route('dashboard', [
            'user' => auth()->user()
        ]))->with('success', 'Welcome Back!');

        // if (auth()->attempt($forminput)) {
        //     session()->regenerate();

        //     if (auth()->user()->is_admin) {
        //         // $token = auth()->guard('api')->attempt($forminput);
        //         return redirect()->intended(route('admindash'))->with('success', 'Admin!');
        //     }

        //     return redirect()->intended(route('dashboard', [
        //         'user' => auth()->user()
        //     ]))->with('success', 'Welcome Back!');
        // }

        // throw ValidationException::withMessages([
        //     'email' => 'Provided credentials are not valid.'
        // ]);
    }

    protected function respondWithToken($token) {
        return response()->json([
            'success' => true,
            'message' => 'User logged in',
            'account' => auth()->guard('api')->user(),
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'access_token' => $token,
        ], 200);
    }
    
    public function destroy() {
        auth()->logout();

        return redirect('/')->with('success', 'Goodbye');
    }
}
