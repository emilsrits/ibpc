<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
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
        $products = Product::where('status', 1)->paginate(12);

        return view('store.index', ['products' => $products]);
    }

    /**
     * Product search
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $input = $request['search'];

        $products = Product::where('status', 1)->where(function ($query) use ($input) {
            $query->where('title', 'like', '%'.$input.'%')
                ->orWhere('code', 'like', '%'.$input.'%');
        })->paginate(12);

        return view('store.index', ['products' => $products ]);
    }

    /**
     * Return store view with products from a category
     *
     * @param $parent
     * @param $child
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categorize($parent, $child)
    {
        $category = Category::where('slug', $child)->first();
        $categoryId = $category->id;

        $products = Product::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })->paginate(12);

        return view('store.index', ['products' => $products]);
    }

    /**
     * Return product view
     *
     * @param $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($code)
    {
        $product = Product::with('attributes.specification')->where('code', $code)->first();

        if ($product->categories()->first()) {
            $categoryId = $product->categories()->first()->id;
            $specifications = Category::with('specifications.attributes')->find($categoryId);
        } else {
            $specifications = null;
        }

        return view('store.product', ['product' => $product], ['specifications' => $specifications]);
    }
}
