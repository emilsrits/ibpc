<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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
    public function getProduct($id)
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
}
