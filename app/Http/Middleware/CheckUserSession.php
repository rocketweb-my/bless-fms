<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ( Session::get('user_id') == null) {
            if (Cookie::get('user_id') == null)
            {
                return redirect()->route('login');
            }else{
                //Set New Session//
                session(['user_id' => Cookie::get('user_id')]);
                if (Cookie::get('user_id') != null) {
                    session(['isadmin' => Cookie::get('isadmin')]);
                }else
                {
                    session(['privileges' => Cookie::get('privileges')]);
                }
            }
            // user_id value cannot be found in session
        }

        return $next($request);
    }
}
