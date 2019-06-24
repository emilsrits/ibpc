<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
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
     * Return admin catalog page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::with('categories')->paginate(20);
        $categories = Category::all();

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

        $products = Product::with('categories')->filter($filters)->paginate(20);
        $categories = Category::all();

        return view('admin.product.catalog', ['products' => $products, 'categories' => $categories, 'request' => $request ]);
    }

    /**
     * Return product creation view
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $categories = Category::where('parent', 0)->get();

        if ($request['category']) {
            $categoryId = json_decode($request['category']);
            $specifications = Category::with('specifications.attributes')->find($categoryId);
        } else {
            $specifications = null;
        }

        return view('admin.product.create', [
            'categories' => $categories,
            'specifications' => $specifications,
            'request' => $request
        ]);
    }

    /**
     * Return category id for AJAX response
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createWithCategory(Request $request)
    {
        $categoryId = $request['selectFieldValue'];
        $category = Category::findOrFail($categoryId);

        if ($category) {
            return response()->json(array('category' => json_encode($categoryId), 'redirectUrl'=> '/admin/product/create?category='), 200);
        } else {
            return response()->json(array('category' => json_encode($categoryId)), 400);
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
        $flash = $action->execute($request->all());
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
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $product = Product::with('categories.specifications.attributes')->find($id);

        if (!$product->getCategoryId()->isEmpty()) {
            $categories = Category::with('specifications.attributes')->find($product->getCategoryId());
        } else {
            $categories = null;
        }

        return view('admin.product.edit', [
            'product' => $product,
            'categories' => $categories,
            'request' => $request
        ]);
    }

    /**
     * Update product
     *
     * @param ProductUpdateRequest $request
     * @param ProductUpdateAction $action
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductUpdateRequest $request, ProductUpdateAction $action, $id)
    {
        $flash = $action->execute($request->all(), $id);
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
        $response = $action->execute($request->all());
        if ($response) {
            return response()->json(null, 200);
        } else {
            return response()->json(null, 400);
        }
    }
}
