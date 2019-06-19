<?php

namespace App\Actions\Product;

use App\Product;

class ProductUpdateAction
{
    /**
     * Process the product update action
     * 
     * @param array $data
     * @param string $id
     * @return void|array
     */
    public function execute(array $data, $id)
    {
        if ($data['submit'] === 'delete') {
            $product = new Product();

            if ($product->deleteProduct($id)) {
                return;
            } else {
                $flash = [
                    'type' => 'message-danger',
                    'message' => 'Can not delete products that are in active orders!'
                ];
            }

            return $flash;
        }

        if ($data['submit'] === 'save') {
            $product = Product::findOrFail($id);

            $img = isset($data['image']) ? $data['image'] : null;
            // Store product image and get its path
            if ($img) {
                if ($product->image_path) {
                    $product->deleteImage();
                }
                $imgPath = $product->storeImage($img, $data['code'], $product->categories->first()->id);
                $product->image_path = $imgPath;
            }
            $product->code = $data['code'];
            $product->title = $data['title'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->stock = $data['stock'];
            $product->status = $data['status'];
            $product->save();

            // Update product attributes
            if (isset($data['attr'])) {
                $product->setAttributes($data['attr']);
            }

            $flash = [
                'type' => 'message-success',
                'message' => 'Product successfully updated!'
            ];
    
            return $flash;
        }

        $flash = [
            'type' => 'message-danger',
            'message' => 'Invalid form action!'
        ];

        return $flash;
    }
}