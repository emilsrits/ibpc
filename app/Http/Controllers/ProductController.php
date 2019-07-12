<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Filters\ProductFilter;
use App\Actions\Product\ProductStoreAction;
use App\Actions\Product\ProductActionAction;
use App\Actions\Product\ProductUpdateAction;
use App\Actions\Product\ProductUpdateAjaxAction;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductActionRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Requests\Product\ProductUpdateAjaxRequest;

class ProductController extends Controller
{
    /**
     * ProductController constructor
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
     * Return admin catalog page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = $this->product->with('categories')->paginate(20);
        $categories = $this->category->all();

        return view('admin.product.catalog', ['products' => $products, 'categories' => $categories, 'request' => null]);
    }

    /**
     * Catalog mass action
     *
     * @param ProductActionRequest $request
     * @param ProductActionAction $action
     * @param ProductFilter $filters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function action(ProductActionRequest $request, ProductActionAction $action, ProductFilter $filters)
    {
        $flash = $action->execute($request->all());
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->back();
        }

        $products = $this->product->with('categories')->filter($filters)->paginate(20);
        $categories = $this->category->all();

        return view('admin.product.catalog', compact('products', 'categories', 'request'));
    }

    /**
     * Return product creation view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = $this->category->child()->get();

        if (old('category')) {
            $category = $this->category->with('specifications.properties')->find(old('category'));
        } else {
            $category = null;
        }

        return view('admin.product.create', compact('categories', 'category'));
    }

    /**
     * Return category id for AJAX response
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createWithCategory(Request $request)
    {
        $category = $this->category->with('specifications.properties')->find($request->selectFieldValue);
        $view = view('partials.admin.product.specifications', ['category'=> $category])->render();

        if ($view) {
            return response()->json($view, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    /**
     * Save created product
     *
     * @param ProductStoreRequest $request
     * @param ProductStoreAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductStoreRequest $request, ProductStoreAction $action)
    {
        $flash = $action->execute($request->validated());
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->route('product.index');
        }

        $request->session()->flash('message-danger', 'Invalid form action!');
        return redirect()->back();
    }

    /**
     * Product edit view
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        $product = $this->product->with('categories.specifications.properties')->find($product->id);

        if (!$product->getCategoryId()->isEmpty()) {
            $category = $this->category->getCategoryWithPropertiesById($product->getCategoryId());
        } else {
            $category = null;
        }

        return view('admin.product.edit', compact('product', 'category'));
    }

    /**
     * Update product
     *
     * @param ProductUpdateRequest $request
     * @param ProductUpdateAction $action
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductUpdateRequest $request, ProductUpdateAction $action, Product $product)
    {
        $flash = $action->execute($request->validated(), $product);
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
            return redirect()->back();
        }

        $request->session()->flash('message-success', 'Product deleted!');
        return redirect()->route('product.index');
    }

    /**
     * Update product with AJAX
     *
     * @param ProductUpdateAjaxRequest $request
     * @param ProductUpdateAjaxAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateWithAjax(ProductUpdateAjaxRequest $request, ProductUpdateAjaxAction $action)
    {
        $response = $action->execute($request->validated());
        if ($response) {
            return response()->json(null, 200);
        } else {
            return response()->json(null, 400);
        }
    }
}
