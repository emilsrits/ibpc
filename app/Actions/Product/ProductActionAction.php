<?php

namespace App\Actions\Product;

use App\Models\Product;

class ProductActionAction
{
    /**
     * Process the product mass-action action
     * 
     * @param array $data
     * @return void|array
     */
    public function execute(array $data)
    {
        if (isset($data['catalog'])) {
            $productIds = $data['catalog'];
            $product = new Product();

            switch ($data['mass-action']) {
                case 1:
                    $product->setStatus($productIds, 1);
                    $flash = [
                        'type' => 'message-success',
                        'message' => 'Product(s) enabled!'
                    ];

                    return $flash;
                case 2:
                    $product->setStatus($productIds, 0);
                    $flash = [
                        'type' => 'message-success',
                        'message' => 'Product(s) disabled!'
                    ];

                    return $flash;
                case 3:
                    if (!$product->deleteProduct($productIds)) {
                        $flash = [
                            'type' => 'message-danger',
                            'message' => 'Can not delete products that are in active orders!'
                        ];
                    } else {
                        $flash = [
                            'type' => 'message-success',
                            'message' => 'Product(s) deleted!'
                        ];
                    }

                    return $flash;
            }
        }

        return;
    }
}