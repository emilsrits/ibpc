<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * ProductController constructor
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin'], ['only' => ['create', 'createWithCategory','store', 'edit', 'update', 'delete']]);
    }

    /**
     * Returns main shop view with all products
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::where('status', '=', 1)->paginate(12);

        return view('shop.index', ['products' => $products]);
    }

    /**
     * Return product view
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $product = Product::with('attributes.specification')->find($id);

        $attributes = new Collection;

        foreach ($product->attributes as $attribute) {
            if (!$attributes->has($attribute->specification->name)) {
                $currentAttributes = new Collection;
            } else {
                $currentAttributes = $attributes->get($attribute->specification->name);
            }
            $currentAttributes->put($attribute->name, $attribute->pivot->value);
            $attributes->put($attribute->specification->name, $currentAttributes);
        }

        return view('shop.product', ['product' => $product], ['specifications' => $attributes]);
    }

    /**
     * Return product creation view
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
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
    public function createWithCategory(Request $request)
    {
        $categoryId = $request['selectFieldValue'];

        $category = Category::find($categoryId);

        if ($category) {
            return response()->json(array('category' => json_encode($categoryId), 'redirectUrl'=> '/admin/product/create?category='), 200);
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
    public function store(Request $request)
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
            $img->storeAs('/public/images/products/' . $request['category'] . '/' , $imgName);
            $imgPath = Product::STORAGE_PRODUCT_IMAGE_PATH . $request['category'] . '/' . $imgName;
        } else {
            $imgPath = null;
        }

        // Check for missing values
        if ($this->productValidate($request)) {
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

    public function edit(Request $request, $id)
    {
        $product = Product::with('categories')->find($id);
        $categories = Category::all();

        if (!$product->getCategoryId()->isEmpty()) {
            $specifications = Category::with('specifications.attributes')->find($product->getCategoryId());
        } else {
            $specifications = null;
        }

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'specifications' => $specifications,
            'request' => $request
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request['submit'] === 'delete') {
            $product = new Product();
            $product->deleteProduct($id);

            $request->session()->flash('message-success', 'Product deleted!');

            return redirect()->route('catalog.index');
        }
    }

    public function delete($id)
    {
        $product = new Product();
        $product->deleteProduct($id);
    }

    /**
     * Check for missing fields on created product
     *
     * @param $request
     * @return bool
     */
    protected function productValidate($request)
    {
        $errors = 0;

        if (!$request['code']) {
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

    /**
     * Check if product exists
     *
     * @param $code
     * @return mixed
     */
    protected function productExists($code) {
        return $product = Product::where('code', $code)->exists();
    }
}
