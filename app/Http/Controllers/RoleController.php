<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * RoleController constructor
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $roles = Role::paginate(20);

        return view('admin.role.roles', ['roles' => $roles]);
    }

    public function role() {
    	request()->user()->assignRole('admin');

    	dd(request()->user()->hasRole('admin'));
    }
}
