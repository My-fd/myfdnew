<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function account()
    {
        return view('web.user.account.account');
    }
    public function register()
    {
        return view('web.user.register');
    }
    public function login()
    {
        return view('web.user.login');
    }
    public function signup()
    {
        return view('web.user.register');
    }
    public function auth()
    {
        return view('web.user.login');
    }
}
