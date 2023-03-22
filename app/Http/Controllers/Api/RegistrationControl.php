<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class RegistrationControl extends Controller
{
    public function register(Request $request) {
        $validation = Validator::make($request->all(), [
            'firstName' => ['required', 'max:255'],
            'lastName' => ['required', 'max:255'],
            'mobileno' => ['required', 'min:10', 'max:10', 'unique:users,mobileno'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:255', 'confirmed'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::create($validation);
      
        $token = auth()->login($user);

        return response()->json([
            'message' => 'Account has been created.',
            'account' => $user,
            'token' => $token
        ], Response::HTTP_CREATED);
    }

    public function validateEntry(Request $request) {
        $validation = Validator::make($request->all(), [
            'firstName' => ['required', 'max:255'],
            'lastName' => ['required', 'max:255'],
            'mobileno' => ['required', 'min:10', 'max:10', 'unique:users,mobileno'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:255', 'confirmed'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
