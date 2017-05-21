<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Category;
use App\Product;

class ProductController extends Controller
{
    /**
     * Reurn admin catalog page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Product::with('categories')->paginate(20);

        return view('admin.product.catalog', ['products' => $products]);
    }

    /**
     * Catalog mass action
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(Request $request)
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
                $product->deleteProduct($productIds);
                $request->session()->flash('message-success', 'Product(s) deleted!');
                break;
        }

        return redirect()->back();
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

        if ($product->categories()->first()) {
            $categoryId = $product->categories()->first()->id;
            $specifications = Category::with('specifications.attributes')->find($categoryId);
        } else {
            $specifications = null;
        }

        return view('store.product', ['product' => $product], ['specifications' => $specifications]);
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

        // Check for missing values
        if ($this->productValidate($request)) {
            return redirect()->back();
        }

        $img = request()->file('image');
        $imgPath = $this->storeImage($img, $request['code'], $request['category']);

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

        return redirect()->route('catalog.index');
    }

    public function edit(Request $request, $id)
    {
        $product = Product::with('categories.specifications.attributes')->find($id);

        if (!$product->getCategoryId()->isEmpty()) {
            $specifications = Category::with('specifications.attributes')->find($product->getCategoryId());
        } else {
            $specifications = null;
        }

        return view('admin.product.edit', [
            'product' => $product,
            'specifications' => $specifications,
            'request' => $request
        ]);
    }

    public function update(Request $request, $id)
    {
        // Delete product
        if ($request['submit'] === 'delete') {
            $product = new Product();
            $product->deleteProduct($id);

            $request->session()->flash('message-success', 'Product deleted!');

            return redirect()->route('catalog.index');
        }

        // Update product
        if ($request['submit'] === 'save') {
            $request->flash();

            $product = Product::find($id);

            if ($request['code'] != $product->code) {
                if ($this->productExists($request['code'])) {
                    $request->session()->flash('message-danger', 'Product with this code already exists!');
                    return redirect()->back();
                } else {
                    $product->code = $request['code'];
                }
            }

            $img = request()->file('image');
            if ($img) {
                $imgPath = $this->storeImage($img, $request['code'], $product->categories->first()->id);

                if ($product->image_path) {
                    $product->deleteImage($id);
                }

                $product->image_path = $imgPath;
            }

            $product->title = $request['title'];
            $product->description = $request['description'];
            $product->price = $request['price'];
            $product->stock = $request['stock'];
            $product->status = $request['status'];
            $product->save();


            $specifications = collect($request['attr']);
            foreach ($specifications as $category => $attributes) {
                foreach ($attributes as $attribute => $value) {
                    $productAttr = $product->attributes->find($attribute);
                    if ($productAttr) {
                        if (!ctype_space($value) && !$value == "") {
                            $product->attributes()->detach(['attribute_id' => ['attribute_id' => $attribute, 'value' => $value]]);
                            $product->attributes()->attach(['attribute_id' => ['attribute_id' => $attribute, 'value' => $value]]);
                        } else {
                            $product->attributes()->detach(['attribute_id' => ['attribute_id' => $attribute, 'value' => $value]]);
                        }
                    } else {
                        if (!ctype_space($value) && !$value == "") {
                            $product->attributes()->attach(['attribute_id' => ['attribute_id' => $attribute, 'value' => $value]]);
                        }
                    }
                }
            }

            $request->session()->flash('message-success', 'Product successfully updated!');

            return redirect()->back();
        }

        $request->session()->flash('message-danger', 'Invalid form action!');

        return redirect()->back();
    }

    /**
     * Delete a product
     *
     * @param $id
     */
    public function delete($id)
    {
        $product = new Product();
        $product->deleteProduct($id);
    }

    /**
     * Store image
     *
     * @param $img
     * @param $code
     * @param $category
     * @return null|string
     */
    protected function storeImage($img, $code, $category)
    {
        if ($img) {
            $imgExt =  $img->guessClientExtension();
            $imgName = $code . str_random(20) . '.' . $imgExt;
            $img->storeAs('/public/images/products/' . $category . '/' , $imgName);
            return Product::STORAGE_PRODUCT_IMAGE_PATH . $category . '/' . $imgName;
        } else {
            return null;
        }
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
        }
        if (!$request['price']) {
            $errors++;
        }
        if (!$request['stock']) {
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
