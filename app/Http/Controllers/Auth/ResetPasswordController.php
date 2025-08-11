<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Staff\PasswordReset;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function reset_password(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user != null)
        {
            $password = Str::random(8) . substr(str_shuffle('~!@#$%^&*()'), 0, 2);
            //Change Text Password to Hash - Start//
            $plaintext = $password;
            $majorsalt  = '';
            $len = strlen($plaintext);

            for ($i=0;$i<$len;$i++)
            {
                $majorsalt .= sha1(substr($plaintext,$i,1));
            }
            $passhash = sha1($majorsalt);

            $user->pass = $passhash;
            $user->save();

            Mail::to($request->email)
            ->send(new PasswordReset($password));

            return view('auth.passwords.after_reset');
        }else{
            return view('auth.passwords.after_reset');
        }

    }
}
