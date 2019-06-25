<?php

namespace App\Actions\Product;

use App\Product;

class ProductUpdateAjaxAction
{
    /**
     * Process the product update ajax action
     * 
     * @param array $data
     * @return mixed
     */
    public function execute(array $data)
    {
        $productId = $data['productId'];
        $product = Product::findOrFail($productId);

        if ($product) {
            // Delete product media files
            $product->media->first()->delete();

            return true;
        } else {
            return false;
        }
    }
}