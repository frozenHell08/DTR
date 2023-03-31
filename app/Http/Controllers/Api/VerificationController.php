<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    public function verifyOTP(Request $request): JsonResponse {
        if (! DB::table('password_reset_tokens')->where('email', $request->email)->exists()) {
            return response()->json([
                'error' => 'Email does not have an active token.'
            ], Response::HTTP_FORBIDDEN);
        }

        $tokenrecord = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if ($tokenrecord->expires_at < now()) {
            return response()->json([
                'error' => 'Token expired.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $otprecord = Otp::where('user_email', $request->email)->first();

        if ($request->otp === $otprecord->otp) {
            return response()->json([
                'message' => 'Successful OTP verification'
            ], Response::HTTP_OK);
        }
    }
}
