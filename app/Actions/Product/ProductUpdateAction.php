<?php

namespace App\Actions\Product;

use App\Media;
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

            // Update product media
            $files = isset($data['media']) ? $data['media'] : null;
            if ($files) {
                foreach ($files as $file) {
                    $media = new Media();
                    $media->type = $file->guessClientExtension();
                    $filePath = $media->storeMedia($file, $product);
                    $media->path = $filePath;
                    $product->media()->save($media);
                }
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