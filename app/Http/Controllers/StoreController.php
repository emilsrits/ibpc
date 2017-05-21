<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Returns main store view with all products
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::where('status', '=', 1)->paginate(12);

        return view('store.index', ['products' => $products]);
    }
}
