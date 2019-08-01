<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Filters\ProductFilter;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductActionRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Requests\Product\ProductUpdateAsyncRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    /**
     * ProductController constructor
     *
     * @param ProductService $productService
     * @param Product $product
     * @param Category $category
     */
    public function __construct(ProductService $productService, Product $product, Category $category)
    {
        $this->productService = $productService;
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
     * @param ProductFilter $filters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function action(ProductActionRequest $request, ProductFilter $filters)
    {
        $action = $this->productService->action($request->validated());
        if ($action) {
            $request->session()->flash($this->productService->message['type'], $this->productService->message['content']);
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
     * Return product creation with new category properties
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAsync(Request $request)
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductStoreRequest $request)
    {
        $this->productService->store($request->validated());

        $request->session()->flash($this->productService->message['type'], $this->productService->message['content']);
        return redirect()->route('product.index');
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
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->productService->update($request->validated(), $product);

        $request->session()->flash($this->productService->message['type'], $this->productService->message['content']);
        return redirect()->back();
    }

    /**
     * Update product async
     *
     * @param ProductUpdateAsyncRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAsync(ProductUpdateAsyncRequest $request)
    {
        $response = $this->productService->updateAsync($request->validated());
        if ($response) {
            return response()->json(null, 200);
        } else {
            return response()->json(null, 400);
        }
    }

    /**
     * Delete product
     *
     * @param Request $request
     * @param Product $product
     * @return mixed
     */
    public function delete(Request $request, Product $product)
    {
        $async = $request->wantsJson();

        $action = $this->productService->delete($product);

        $request->session()->flash($this->productService->message['type'], $this->productService->message['content']);

        if ($async) {
            if ($action) {
                return response()->json(array('redirectUrl'=> route('product.index')), 200);
            }
            return response()->json(null, 400);
        }
        
        if ($action) {
            return redirect()->route('product.index');
        }
        return redirect()->back();
    }
}
