<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetEmail;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function sendResetOTPEmail(Request $request): JsonResponse {
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'error' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $token = $this->createToken($user);
        $otp = $this->createOTP($user);

        Mail::to($user)->send(new PasswordResetEmail($token, $user, $otp));

        return response()->json([
            'message' => 'Reset link sent',
            'otp' => $otp,
            'token' => $token
        ], Response::HTTP_OK);
    }

    public function sendResetLinkEmail(Request $request): JsonResponse {

        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink(
            $request->only('email')
        );

        if ($response === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'password link sent']);
        } else {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }
    }

    public function newPassword(Request $request): JsonResponse {
        $validation = Validator::make($request->all(), [
            'password' => ['required', 'min:8', 'max:255', 'confirmed'],
            'password_confirmation' => ['required', 'min:8', 'max:255'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where('email', $request->email)->first();

        $oldpassword = $user->password;

        $user->update(['password' => $request->password]);

        return response()->json([
            'message' => 'Successfully changed password',
            'old password' => $oldpassword,
            'new password' => $user->password
        ], Response::HTTP_ACCEPTED);
    }

        /**
     * Create a token for the given user.
     *
     * @param  \App\Models\User  $user
     * @return string
     */
    protected function createToken(User $user)
    {
        $token = Str::random(60);
        $expiration = Carbon::now()->addMinutes(5);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'expires_at' => $expiration,
                'created_at' => Carbon::now(),
        ]);

        return $token;
    }

    protected function createOTP(User $user) {
        
        $random_number = rand(100000, 999999);
        
        $record = Otp::updateOrInsert(
            ['user_email' => $user->email],
            [
                'otp' => $random_number,
                'created_at' => now(),
                'updated_at' => now()
            ],
        );

        return $random_number;
    }
}
