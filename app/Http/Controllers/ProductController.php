<?php

namespace App\Http\Controllers;

use App\Admin\Tables\ProductTable;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Filters\ProductFilter;
use App\Services\ProductService;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductActionRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Requests\Product\ProductUpdateAsyncRequest;
use App\Traits\PaginatesModels;

class ProductController extends Controller
{
    use PaginatesModels;

    /**
     * ProductController constructor
     *
     * @param ProductService $productService
     * @param ProductRepository $productRepository
     * @param ProductTable $productTable
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        ProductService $productService,
        ProductRepository $productRepository,
        ProductTable $productTable,
        CategoryRepository $categoryRepository
    ) {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
        $this->productTable = $productTable;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Return admin catalog page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if ($this->setSessionPageSize()) {
            return response()->json(array('redirectUrl' => request()->url()), 200);
        }

        $products = $this->productRepository->with('categories')->paginate();

        return view('admin.product.catalog', [
            'products' => $products,
            'table' => $this->productTable
        ]);
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
            return redirect()->back();
        }

        $products = $this->productRepository->with('categories')->filter($filters)->paginate();
        $table = $this->productTable;

        return view('admin.product.catalog', compact('products', 'table', 'request'));
    }

    /**
     * Return product creation view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = $this->categoryRepository->child()->get();

        if (old('category')) {
            $category = $this->categoryRepository->with('specifications.properties')->find(old('category'));
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
        $category = $this->categoryRepository->with('specifications.properties')->find($request->selectValue);
        $view = view('admin.product._partials.specifications', ['category'=> $category])->render();

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
        $product = $this->productRepository->with('categories.specifications.properties')->find($product->id);

        if ($product->getCategoryId()) {
            $category = $this->categoryRepository->with('specifications.properties')->find($product->getCategoryId());
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
        $action = $this->productService->delete($product, $async);

        if ($async) {
            if ($action) {
                return response()->json(array('redirectUrl' => route('product.index')), 200);
            }
            return response()->json(messageItem('message-danger', 'Can not delete products that are in active orders!'), 400);
        }
        
        if ($action) {
            return redirect()->route('product.index');
        }
        return redirect()->back();
    }
}
