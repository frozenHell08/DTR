<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function profilePic(Request $request, User $user) { 
        $validation = Validator::make($request->all(), [
            'image' => ['required', 'image', 'max:10024']
        ]);

        if ($validation->fails()) {
            return response()->json([
                'error' => $validation->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    
        if (! is_null($user->profile_picture)) {
            Storage::delete($user->profile_picture);
        }

        $file = $request->file('image');

        $filename = $user->lastName . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/images/profile', $filename);

        $user->update(['profile_picture' => $path]);

        return response()->json([
            'message' => 'Image changed.',
            'path' => $path,
        ]);
    }

    public function editProfile(Request $request, User $user): JsonResponse {
        $validation = Validator::make($request->all(), [
            'firstName' => ['nullable', 'min:2', 'max:255'],
            'lastName' => ['nullable', 'min:2', 'max:255'],
            'mobileno' => ['nullable', 'min:10', 'max:10', 'unique:users,mobileno'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (! is_null($request->firstName)) {
            $user->firstName = $request->firstName;
        }

        if (! is_null($request->lastName)) {
            $user->lastName = $request->lastName;
        }

        if (! is_null($request->mobileno)) {
            $user->mobileno = $request->mobileno;
        }

        if ($user->isDirty()) {
            $user->save();
        }

        return response()->json([
            'request' => $request->all(),
            'user' => $user,
            'changes' => $user->getChanges()
        ], Response::HTTP_OK);
    }

    public function resetPassword(Request $request): JsonResponse {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($response === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successful.']);
        } else {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }
    }
}
