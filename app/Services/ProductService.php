<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Media;

class ProductService
{
    /**
     * @var array
     */
    public $message;

    /**
     * @var Product
     */
    protected $product;
    
    /**
     * Create a new service instance.
     */
    public function __construct(Product $product)
    {
        $this->message = [
            'type' => null,
            'content' => null
        ];
        $this->product = $product;
    }

    /**
     * Product mass action
     *
     * @param array $data
     * @return mixed
     */
    public function action(array $data)
    {
        if (isset($data['catalog'])) {
            $productIds = $data['catalog'];

            switch ($data['mass-action']) {
                case 1:
                    $this->product->setStatus($productIds, 1);
                    $this->message = [
                        'type' => 'message-success',
                        'content' => 'Product(s) enabled!'
                    ];

                    return true;
                case 2:
                    $this->product->setStatus($productIds, 0);
                    $this->message = [
                        'type' => 'message-success',
                        'content' => 'Product(s) disabled!'
                    ];

                    return true;
                case 3:
                    if (!$this->product->deleteProduct($productIds)) {
                        $this->message = [
                            'type' => 'message-danger',
                            'content' => 'Can not delete products that are in active orders!'
                        ];
                    } else {
                        $this->message = [
                            'type' => 'message-success',
                            'content' => 'Product(s) deleted!'
                        ];
                    }

                    return true;
            }
        }

        return false;
    }

    /**
     * Product store action
     *
     * @param array $data
     */
    public function store(array $data)
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
                    $this->message = [
                        'type' => 'message-info',
                        'content' => 'Maximum media amount for product exceeded!'
                    ];
                }
            }
        }

        $this->message = [
            'type' => 'message-success',
            'content' => 'Product successfully created!'
        ];
    }

    /**
     * Product update action
     *
     * @param array $data
     * @param Product $product
     * @return bool
     */
    public function update(array $data, Product $product)
    {
        
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
                $uploaded = $media->storeMedia($file, $product);

                if ($uploaded) {
                    $product->media()->save($media);
                } else {
                    $this->message = [
                        'type' => 'message-info',
                        'content' => 'Maximum media amount for product exceeded!'
                    ];

                    return false;
                }
            }
        }

        $this->message = [
            'type' => 'message-success',
            'content' => 'Product successfully updated!'
        ];

        return true;
    }

    /**
     * Product async update
     *
     * @param array $data
     * @return bool
     */
    public function updateAsync(array $data)
    {
        $productId = $data['productId'];
        $mediaId = $data['mediaId'];
        $product = Product::findOrFail($productId);

        if ($product) {
            $product->media->find($mediaId)->delete();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Product delete action
     *
     * @param Product $product
     * @return bool
     */
    public function delete(Product $product)
    {
        if ($product->deleteProduct()) {
            $this->message = [
                'type' => 'message-success',
                'content' => 'Product deleted!'
            ];

            return true;
        } else {
            $this->message = [
                'type' => 'message-danger',
                'content' => 'Can not delete products that are in active orders!'
            ];

            return false;
        }
    }
}