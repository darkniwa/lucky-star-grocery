<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\User;

class OtpVerificationController extends Controller
{
    public function sendOtp(Request $request)
    {
        // Generate OTP (you can use your own logic here)
        $otp = mt_rand(100000, 999999);


        // Save OTP to database
        Otp::updateOrCreate(
            ['phone_number' => $request->phone_number],
            ['otp' => $otp]
        );

        // Send OTP via Twilio
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create(
                $request->phone_number,
                [
                    "from" => env('TWILIO_PHONE_NUMBER'),
                    "body" => "Lucky Star OTP: " . $otp,
                ]
            );

        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function verifyOtp(Request $request)
    {
        $phoneNumber = $request->input('phone_number');
        $enteredOtp = $request->input('otp');

        $otpRecord = Otp::where('phone_number', $phoneNumber)->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Phone number not found'], 404);
        }

        if ($otpRecord->otp === $enteredOtp) {
            // Successful verification
            // You can update the verified status in your database or perform other actions

            return response()->json(['message' => 'OTP verified successfully']);
        }

        return response()->json(['message' => 'Invalid OTP'], 422);
    }

    public function checkUniqueNumber(Request $request)
    {
        $mobileNumber = $request->input('mobileNumber');

        // Perform your logic to check if the mobile number already exists in the database
        // For example, you might have a User model and check for the existence of the number:
        $userExists = User::where('mobile', $mobileNumber)->exists();

        return response()->json(['status' => $userExists ? 'exists' : 'unique']);
    }
}
