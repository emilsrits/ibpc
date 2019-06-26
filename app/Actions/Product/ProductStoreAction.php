<?php

namespace App\Actions\Product;

use App\Product;
use App\Media;

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

        // Store product media files
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
            'message' => 'Product successfully created!'
        ];

        return $flash;
    }
}