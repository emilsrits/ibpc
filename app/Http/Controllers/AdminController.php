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
    const STORAGE_PRODUCT_IMAGE_PATH = '/storage/images/products/';

    const DEFAULT_PRODUCT_IMAGE_PATH = '/images/products/default.png';

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Return admin panel view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdmin()
    {
        return view('admin.index', ['user' => Auth::user()]);
    }

    /**
     * Reurn catalog page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCatalog()
    {
        $products = Product::paginate(20);
        return view('admin.products.catalog', ['products' => $products]);
    }

    /**
     * Catalog mass action
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postMassAction(Request $request)
    {
        $productIds = $request->input('catalog');
        $product = new Product();

        switch ($request->input('mass-action')) {
            case 1:
                $product->setStatus($productIds, 1);
                $request->session()->flash('message-success', 'Product(s) enabled!');
                break;
            case 2:
                $product->setStatus($productIds, 0);
                $request->session()->flash('message-success', 'Product(s) disabled!');
                break;
            case 3:
                dd('penis');
                break;
            case 4:
                $product->deleteProduct($productIds);
                $request->session()->flash('message-success', 'Product(s) deleted!');
                break;
        }

        return redirect()->back();
    }

    /**
     * Return product creation view
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateProduct(Request $request)
    {
        $categories = Category::all();

        if ($request['category']) {
            $categoryId = json_decode($request['category']);
            $specifications = Category::with('specifications.attributes')->find($categoryId);
        } else {
            $specifications = null;
        }

        return view('admin.products.create', [
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
    public function getAjaxCategoryId(Request $request)
    {
        $categoryId = $request['selectFieldValue'];

        $category = Category::find($categoryId);

        if ($category) {
            return response()->json(array('category' => json_encode($categoryId), 'redirectUrl'=> '/admin/products/create?category='), 200);
        } else {
            return response()->json(array('category' => json_encode($categoryId)), 400);
        }
    }

    /**
     * Save created product
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSaveProduct(Request $request)
    {
        $request->flash();

        if ($this->productExists($request['code'])) {
            $request->session()->flash('message-danger', 'Product with this code already exists!');
            return redirect()->back();
        }

        $img = request()->file('image');
        if ($img) {
            $imgExt =  $img->guessClientExtension();
            $imgName = $request['code'] . str_random(20) . '.' . $imgExt;
            $img->storeAs('/public/images/products/', $imgName);
            $imgPath = self::STORAGE_PRODUCT_IMAGE_PATH . $imgName;
        } else {
            $imgPath = self::DEFAULT_PRODUCT_IMAGE_PATH;
        }

        // Check for missing values
        if ($this->validateCreatedProduct($request)) {
            return redirect()->back();
        }

        $product = new Product();
        $product->image_path = $imgPath;
        $product->code = $request['code'];
        $product->title = $request['title'];
        $product->description = $request['description'];
        $product->price = $request['price'];
        $product->stock = $request['stock'];
        $product->status = $request['status'];
        $product->save();

        if ($request['category']) {
            $product->categories()->attach(['category_id' => $request['category']]);

            $specifications = collect($request['attr']);
            foreach ($specifications as $category => $attributes) {
                foreach ($attributes as $attribute => $value) {
                    if ($value) {
                        $product->attributes()->attach(['attribute_id' => ['attribute_id' => $attribute, 'value' => $value]]);
                    }
                }
            }
        }

        $request->session()->flash('message-success', 'Product successfully created!');

        return back();
    }

    public function getEditProduct($id)
    {
        $product = Product::find($id);
        $categories = Category::all();

        return view('admin.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Check for missing fields on created product
     *
     * @param $request
     * @return bool
     */
    protected function validateCreatedProduct($request)
    {
        $errors = 0;

        if (!$request['category']) {
            $errors++;
        } if (!$request['code']) {
            $errors++;
        } if (!$request['price']) {
            $errors++;
        } if (!$request['stock']) {
            $errors++;
        } if (!$request['status']) {
            $errors++;
        }

        if ($errors) {
            $request->session()->flash('message-danger', 'Invalid form data!');
            return true;
        } else {
            return false;
        }
    }

    protected function productExists($code) {
        return $product = Product::where('code', $code)->exists();
    }
}
