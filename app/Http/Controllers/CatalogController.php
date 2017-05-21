<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Attribute;
use App\Specification;

class CatalogController extends Controller
{
    /**
     * Reurn catalog page
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
}
