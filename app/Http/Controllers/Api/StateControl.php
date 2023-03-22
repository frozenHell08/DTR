<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StateControl extends Controller
{
    public function login(Request $request) {
        $validation = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $credentials = $request->only('email', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([

            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message' => 'User logged in',
            'account' => auth()->user(),
            'token' => $token,
            'expires_in' => Auth::factory()->getTTL() * 60,
            'payload' => Auth::payload(),
        ], Response::HTTP_CREATED);
    }

    public function logout() {
        auth()->logout();

        return response()->json([
            'message' => 'User has been logged out.'
        ], Response::HTTP_OK);
    }
}
