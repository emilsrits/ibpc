<?php

namespace App\Http\Controllers;

use App\Traits\PaginatesModels;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Http\Requests\Store\StoreSearchRequest;

class StoreController extends Controller
{
    use PaginatesModels;
    
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
        if ($this->setSessionPageSize()) {
            return response()->json(array('redirectUrl' => request()->url()), 200);
        }

        $products = $this->productRepository->active()->paginate();

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
     * @param string $parent
     * @param string $child
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categorize($parent, $child)
    {
        if ($this->setSessionPageSize()) {
            return response()->json(array('redirectUrl' => request()->url()), 200);
        }
        
        $categoryId = $this->categoryRepository->findBy('slug', $child)->id;
        $products = $this->productRepository->active()->getByCategoryId($categoryId)->paginate();
        
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
