<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController as DefaultLoginController;

class TestController extends DefaultLoginController
{
    public function index()
    {

        $users = User::all();
        $test = Auth::attempt(['email' => 'syafiqchenor@gmail.com', 'password' => 'Apple@2293']);
        dd($test);

        $plaintext = '22061993';
            $majorsalt  = '';
            $len = strlen($plaintext);
            for ($i=0;$i<$len;$i++)
            {
                $majorsalt .= sha1(substr($plaintext,$i,1));
            }
            dump($majorsalt);
            $corehash = sha1($majorsalt);
            dd($corehash);

        $test = password_verify('22061993', 'b991428b510b17acbd6ecc38881c4bad6e399d6a');

        dd($test);

    }

    public function username()
    {
        return 'user';
    }
    protected function guard()
    {
        return Auth::guard('fms_users');
    }
}
