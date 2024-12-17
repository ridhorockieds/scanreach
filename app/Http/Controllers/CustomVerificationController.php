<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CustomVerificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->status == 'inactive') {
            return view('auth.verify');
        }

        return redirect()->route('dashboard');
    }

    public function resendVerification(Request $request)
    {
        $user = Auth::user();
        $otpResendLimit = 10;
        $otpResendTimeout = now()->subMinutes($otpResendLimit);

        if ($user->otp_resend_at && Carbon::parse($user->otp_resend_at)->gt($otpResendTimeout)) {
            return response()->json([
                'message' => 'You can only resend OTP code once every ' . $otpResendLimit . ' minutes.',
            ], 429);
        } elseif ($user->status == 'inactive') {
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $otp_expires_at = now()->addMinutes($otpResendLimit);
            $user->fill([
                'otp' => $otp,
                'otp_expires_at' => $otp_expires_at,
                'otp_resend_at' => now(),
            ])->save();

            Mail::send('auth.otp', ['fullname' => $user->fullname, 'otp' => $user->otp], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('OTP Code Verification');
            });

            return response()->json([
                'message' => 'OTP code has been sent to your email',
            ], 200);
        } else {
            return redirect()->route('dashboard');
        }
    }
}
