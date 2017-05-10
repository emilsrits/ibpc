<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Role;
use App\User;
use App\Product;
use App\Category;
use App\Attribute;
use App\Specification;

class AdminController extends Controller
{
    /**
     * Return admin panel view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index', ['user' => Auth::user()]);
    }
}
