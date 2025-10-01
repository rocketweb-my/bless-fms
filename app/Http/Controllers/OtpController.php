<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\PersonInCharge;

class OtpController extends Controller
{
    /**
     * Show PIC login page
     */
    public function showLoginForm()
    {
        return view('pages.pic.login');
    }

    /**
     * Request OTP for registered PIC
     */
    public function requestOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find PIC by email
        $pic = PersonInCharge::where('email', $request->email)
            ->where('status', 1)
            ->first();

        if (!$pic) {
            return response()->json([
                'success' => false,
                'message' => 'Email not found. Please contact administrator to register as Person In Charge.',
            ], 404);
        }

        // Check rate limiting - prevent spam (1 OTP per minute)
        if ($pic->last_otp_request && $pic->last_otp_request->diffInSeconds(now()) < 60) {
            return response()->json([
                'success' => false,
                'message' => 'Please wait before requesting another OTP. You can request a new OTP in ' . (60 - $pic->last_otp_request->diffInSeconds(now())) . ' seconds.',
            ], 429);
        }

        try {
            // Generate and send OTP
            $pic->generateOtp();

            // Store PIC ID in session
            Session::put('pic_id', $pic->id);
            Session::put('pic_email', $pic->email);

            return response()->json([
                'success' => true,
                'message' => 'OTP has been sent to your email. Please check your inbox.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again later.',
            ], 500);
        }
    }

    /**
     * Show OTP verification page
     */
    public function showVerifyForm()
    {
        if (!Session::has('pic_id')) {
            return redirect()->route('pic.login')->with('error', 'Please request OTP first.');
        }

        return view('pages.pic.verify-otp');
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if (!Session::has('pic_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please request OTP again.',
            ], 401);
        }

        $pic = PersonInCharge::find(Session::get('pic_id'));

        if (!$pic) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid session. Please request OTP again.',
            ], 401);
        }

        if ($pic->verifyOtp($request->otp)) {
            // OTP verified successfully
            Session::put('pic_authenticated', true);
            Session::put('pic_name', $pic->name);

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully!',
                'redirect' => route('pic.create.ticket'),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP. Please try again.',
            ], 401);
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        if (!Session::has('pic_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please request OTP again.',
            ], 401);
        }

        $pic = PersonInCharge::find(Session::get('pic_id'));

        if (!$pic) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid session.',
            ], 401);
        }

        // Check rate limiting
        if ($pic->last_otp_request && $pic->last_otp_request->diffInSeconds(now()) < 60) {
            return response()->json([
                'success' => false,
                'message' => 'Please wait before requesting another OTP.',
            ], 429);
        }

        try {
            $pic->generateOtp();

            return response()->json([
                'success' => true,
                'message' => 'New OTP has been sent to your email.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again later.',
            ], 500);
        }
    }

    /**
     * Logout PIC
     */
    public function logout()
    {
        Session::forget(['pic_id', 'pic_email', 'pic_authenticated', 'pic_name']);
        return redirect()->route('pic.login')->with('success', 'You have been logged out.');
    }
}
