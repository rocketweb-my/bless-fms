<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Ferdous\OtpValidator\Object\OtpRequestObject;
use Ferdous\OtpValidator\OtpValidator;
use Ferdous\OtpValidator\Object\OtpValidateRequestObject;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
    public function requestForOtp(Request $request)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 10;
        $code = '';

        while (strlen($code) < $codeLength) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code.$character;
        }
        $client_id = $code;

        $otp_request =  OtpValidator::requestOtp(
            new OtpRequestObject($client_id, $request->type, '', $request->email)
        );

        if($tp_request['code'] = 201)
        {
            Session::put('uid_otp', $otp_request['uniqueId']);
            Session::put('email_otp', $request->email);
        }

        return $otp_request;
    }

    public function validateOtp(Request $request)
    {
        $uniqId = $request->otp_uid;
        $otp = $request->otp;

        $otp_verification = OtpValidator::validateOtp(
            new OtpValidateRequestObject($uniqId,$otp)
        );
        if($otp_verification['code'] = 200)
        {
            Session::put('email_otp_verified', 1);
        }
        return $otp_verification;
    }

    public function resendOtp(Request $request)
    {
        $uniqueId = $request->input('uniqueId');
        return OtpValidator::resendOtp($uniqueId);
    }
}
