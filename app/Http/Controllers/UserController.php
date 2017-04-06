<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
	protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }
}
