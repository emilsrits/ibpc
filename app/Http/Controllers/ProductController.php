<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    /**
     * Returns main shop view with all products
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
    	$products = Product::paginate(12);

    	return view('shop.index', ['products' => $products]);
    }

    /**
     * Return product view
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewProduct($id)
    {
        $product = Product::with('specifications')->find($id);

        $specifications = new Collection;

        foreach ($product->specifications as $specification) {
            if (!$specifications->has($specification->name)) {
                $currentSpecs = new Collection;
            } else {
                $currentSpecs = $specifications->get($specification->name);
            }
            $currentSpecs->put($specification->pivot->attribute, $specification->pivot->value);
            $specifications->put($specification->name, $currentSpecs);
        }

        return view('shop.product', ['product' => $product], ['specifications' => $specifications]);
    }
}
