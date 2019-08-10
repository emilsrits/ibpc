<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreSearchRequest;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

class StoreController extends Controller
{
    /**
     * StoreController constructor
     *
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Returns main store view with all products
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = $this->productRepository->active()->paginate(16);

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
        $products = $this->productRepository->active()->getByTitleOrCode($request->q)->paginate(16);

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
        $categoryId = $this->categoryRepository->findBy('slug', $child)->id;
        $products = $this->productRepository->active()->getByCategoryId($categoryId)->paginate(16);
        
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
        $product = $this->productRepository->with('properties.specification')->findBy('code', $code);

        return view('store.product', compact('product'));
    }
}
