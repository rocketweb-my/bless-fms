<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
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

        if($user == null)
        {
            toastr()->error('Credential Incorrect', 'Error');
            return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
        }

        if($user->is_active == 0){
            toastr()->error('User is Inactive', 'Error');
            return redirect('login')->with('error', 'Oppes! You account is inactive');
        }

        //Change Text Password to Hash - Start//
        $plaintext = $request->password;
        $majorsalt  = '';
        $len = strlen($plaintext);

        for ($i=0;$i<$len;$i++)
        {
            $majorsalt .= sha1(substr($plaintext,$i,1));
        }
        $corehash = sha1($majorsalt);
        //Change Text Password to Hash - End//

        if ($corehash === $user->pass) {
            session(['user_id' => $user->id]);

            if ($user->isadmin == 1)
            {
                session(['isadmin' => 1]);
            }else
            {
                session(['privileges' => $user->heskprivileges]);
            }


            if ($request->remember_me == 1)
            {
                Cookie::queue('user_id', $user->id, 1000);
                if ($user->isadmin == 1)
                {
                    Cookie::queue('isadmin', 1, 1000);
                }else
                {
                    Cookie::queue('privileges', $user->heskprivileges, 1000);
                }

            }

            return redirect()->route('dashboard.index');
        }
        else {
            toastr()->error('Credential Incorrect', 'Error');
            return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
        }

    }

    public function logout(Request $request){
        $request->session()->flush();
        Cookie::queue(Cookie::forget('user_id'));
        return redirect()->route('login');
    }
}
