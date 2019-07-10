<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\Store\StoreSearchRequest;

class StoreController extends Controller
{
    /**
     * StoreController constructor
     *
     * @param Product $product
     * @param Category $category
     */
    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    /**
     * Returns main store view with all products
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = $this->product->active()->paginate(12);

        return view('store.index', compact('products'));
    }

    /**
     * Product search
     *
     * @param \App\Http\Requests\Store\StoreSearchRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(StoreSearchRequest $request)
    {
        $products = $this->product->getByTitleAndCode($request->q)->paginate(12);

        return view('store.index', compact('products'));
    }

    /**
     * Return store view with products from a category
     *
     * @param $top_level
     * @param $child
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categorize($top_level, $child)
    {
        $categoryId = $this->category->ofSlug($child)->first()->id;
        $products = $this->product->getByCategoryId($categoryId)->paginate(12);
        
        return view('store.index', compact('products'));
    }

    /**
     * Return product view
     *
     * @param $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($code)
    {
        $product = $this->product->getWithSpecificationsByCode($code);
        // Get product properties associated with its category
        if ($product->categories()->first()) {
            $categoryId = $product->categories()->first()->id;
            $specifications = Category::with('specifications.properties')->find($categoryId);
        } else {
            $specifications = null;
        }

        return view('store.product', compact('product', 'specifications'));
    }
}
