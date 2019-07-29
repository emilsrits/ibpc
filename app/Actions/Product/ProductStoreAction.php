<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Models\Media;

class ProductStoreAction
{
    /**
     * Process the product store action
     * 
     * @param array $data
     * @return mixed
     */
    public function execute(array $data)
    {
        $data['price'] = parseMoneyByDecimal($data['price']);

        $product = Product::create(arrayExclude($data, [
            'category', 'properties', 'media'
        ]));

        // Attach category and its properties to the product
        $product->categories()->attach(['category_id' => $data['category']]);
        if (isset($data['properties'])) {
            $product->setProperties($data['properties']);
        }

        // Store product media files
        $files = isset($data['media']) ? $data['media'] : null;
        if ($files) {
            foreach ($files as $file) {
                $media = new Media();
                $uploaded = $media->storeMedia($file, $product);

                if ($uploaded) {
                    $product->media()->save($media);
                } else {
                    $flash = [
                        'type' => 'message-info',
                        'message' => 'Maximum media amount for product exceeded!'
                    ];

                    return $flash;
                }
            }
        }

        $flash = [
            'type' => 'message-success',
            'message' => 'Product successfully created!'
        ];

        return $flash;
    }
}