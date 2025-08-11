<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController2 extends Controller
{
    public function login()
    {
        if ( session('user_id') != null ) {
            return redirect()->route('ticket.index');
        }else {
            return view('auth.login');
        }
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        $plaintext = $request->password;
        $majorsalt  = '';
        $len = strlen($plaintext);

        for ($i=0;$i<$len;$i++)
        {
            $majorsalt .= sha1(substr($plaintext,$i,1));
        }
        $corehash = sha1($majorsalt);

        if ($corehash === $user->pass) {
            session(['user_id' => $user->id]);
            if ($request->remember_me == 1)
            {
                session(['remember_me' => $user->id]);
            }
            return redirect()->intended('/');
        }
        else {
            return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
        }

    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect()->route('login');
    }
}
