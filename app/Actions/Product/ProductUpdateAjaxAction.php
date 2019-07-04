<?php

namespace App\Actions\Product;

use App\Models\Product;

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
        $mediaId = $data['mediaId'];
        $product = Product::findOrFail($productId);

        if ($product) {
            // Delete product media files
            $product->media->find($mediaId)->delete();

            return true;
        } else {
            return false;
        }
    }
}