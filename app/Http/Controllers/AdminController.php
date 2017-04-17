<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\User;
use App\Product;

class AdminController extends Controller
{
    const storageProductImagePath = '/storage/images/products/';

    const defaultProductImage = 'default.png';

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
    public function index()
    {
        return view('admin.index', ['user' => Auth::user()]);
    }

    /**
     * Return product creation view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createProduct()
    {
        //dd(Category::all());
        $categories = Category::all();
        return view('admin.products.create', ['categories' => $categories]);
    }

    /**
     * Save created product
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveCreatedProduct(Request $request)
    {
        $img = request()->file('image');
        if ($img) {
            $imgExt =  $img->guessClientExtension();
            $imgName = $request['code'] . str_random(20) . '.' . $imgExt;
            $img->storeAs('/public/images/products/', $imgName);
        } else {
            $imgName = self::defaultProductImage;
        }

        $product = new Product();
        $product->image_path = self::storageProductImagePath . $imgName;
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

        return back();
    }
}
