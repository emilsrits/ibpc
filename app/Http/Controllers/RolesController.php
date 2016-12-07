<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function role() {
    	request()->user()->assignRole('admin');

    	dd(request()->user()->hasRole('admin'));
    }
}
