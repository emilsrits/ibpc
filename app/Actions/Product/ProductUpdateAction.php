<?php

namespace App\Actions\Product;

use App\Models\Media;
use App\Models\Product;

class ProductUpdateAction
{
    /**
     * Process the product update action
     * 
     * @param array $data
     * @param Product $product
     * @return mixed
     */
    public function execute(array $data, $product)
    {
        if ($data['submit'] === 'delete') {
            if ($product->deleteProduct()) {
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
            $data['price'] = parseMoneyByDecimal($data['price']);
            
            $product->update(arrayExclude($data, [
                'category', 'properties', 'media'
            ]));

            // Update product properties
            if (isset($data['properties'])) {
                $product->updateProperties($data['properties']);
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