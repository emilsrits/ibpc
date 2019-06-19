<?php

namespace App\Actions\Product;

use App\Product;

class ProductStoreAction
{
    /**
     * Process the product store action
     * 
     * @param array $data
     * @return void|array
     */
    public function execute(array $data)
    {
        $product = new Product();

        $img = isset($data['image']) ? $data['image'] : null;
        // Store product image and get its path
        $imgPath = $product->storeImage($img, $data['code'], $data['category']);
        $product->image_path = $imgPath;
        $product->code = $data['code'];
        $product->title = $data['title'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->stock = $data['stock'];
        $product->status = $data['status'];
        $product->save();

        // Attach category and its attributes to the product
        $product->categories()->attach(['category_id' => $data['category']]);
        if (isset($data['attr'])) {
            $product->setAttributes($data['attr']);
        }

        $flash = [
            'type' => 'message-success',
            'message' => 'Product successfully created!'
        ];

        return $flash;
    }
}