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
    const storageProductImagePath = '/storage/images/products/';

    const defaultProductImagePath = '/images/products/default.png';

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

    public function getCatalog()
    {
        $products = Product::paginate(20);
        return view('admin.products.catalog', ['products' => $products]);
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

        if ($request['specifications']) {
            $specifications = json_decode($request['specifications']);
        } else {
            $specifications = null;
        }

        return view('admin.products.create', ['categories' => $categories, 'specifications' => $specifications]);
    }

    public function getProductSpecifications(Request $request)
    {
        $categoryId = $request['selectFieldValue'];

        $specifications = Category::with('specifications.attributes')->find($categoryId);

        return response()->json(array('data' => json_encode($specifications), 'redirectUrl'=> '/admin/products/create?specifications='), 200);
    }

    /**
     * Save created product
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSaveProduct(Request $request)
    {
        $img = request()->file('image');
        if ($img) {
            $imgExt =  $img->guessClientExtension();
            $imgName = $request['code'] . str_random(20) . '.' . $imgExt;
            $img->storeAs('/public/images/products/', $imgName);
            $imagePath = self::storageProductImagePath . $imgName;
        } else {
            $imagePath = self::defaultProductImagePath;
        }

        // Check for missing values
        if ($this->validateCreatedProduct($request)) {
            return redirect()->back();
        }

        $product = new Product();
        $product->image_path = $imagePath;
        $product->code = $request['code'];
        $product->title = $request['title'];
        $product->description = $request['description'];
        $product->price = $request['price'];
        $product->stock = $request['stock'];
        $product->status = $request['status'];
        $product->save();

        if ($request['category']) {
            $product->categories()->attach(['category_id' => $request['category']]);
        }

        $request->session()->flash('message-success', 'Product successfully created!');

        return back();
    }

    public function getEditProduct(Request $request)
    {
        $product = Product::find($request['id']);
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
            $request->session()->flash('message-danger', 'Fill all the required fields!');
            return true;
        } else {
            return false;
        }
    }
}
