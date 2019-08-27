<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Media;
use App\Repositories\ProductRepository;

class ProductService
{
    /**
     * Create a new service instance.
     * 
     * @param Product $product
     * @param ProductRepository $productRepository
     */
    public function __construct(Product $product, ProductRepository $productRepository)
    {
        $this->product = $product;
        $this->productRepository = $productRepository;
    }

    /**
     * Product mass action
     *
     * @param array $data
     * @return mixed
     */
    public function action(array $data)
    {
        if (isset($data['product'])) {
            $productIds = $data['product'];

            switch ($data['mass-action']) {
                case 1:
                    $this->product->setStatus($productIds, 1);
                    flashMessage('message-success', 'Product(s) enabled!');
                    return true;
                case 2:
                    $this->product->setStatus($productIds, 0);
                    flashMessage('message-success', 'Product(s) disabled!');
                    return true;
                case 3:
                    if (!$this->product->deleteProduct($productIds)) {
                        flashMessage('message-danger', 'Can not delete products that are in active orders!');
                        return false;
                    }
                    flashMessage('message-success', 'Product(s) deleted!');
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

        $product = $this->productRepository->create(arrayExclude($data, [
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
                    flashMessage('message-info', 'Maximum media amount for product exceeded!');
                }
            }
        }

        flashMessage('message-success', 'Product successfully created!');
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
        
        $this->productRepository->update(arrayExclude($data, [
            'category', 'properties', 'media'
        ]), $product);

        // Update product properties
        if (isset($data['properties'])) {
            $product->updateProperties($data['properties']);
        } else {
            $product->updateProperties([]);
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
                    flashMessage('message-info', 'Maximum media amount for product exceeded!');
                    return false;
                }
            }
        }

        flashMessage('message-success', 'Product successfully updated!');
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
        $product = $this->productRepository->find($productId);

        if ($product) {
            $product->media->find($mediaId)->delete();
            return true;
        }
        return false;
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
            flashMessage('message-success', 'Product deleted!');
            return true;
        }
        flashMessage('message-danger', 'Can not delete products that are in active orders!');
        return false;
    }
}
