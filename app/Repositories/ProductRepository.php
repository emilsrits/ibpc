<?php

namespace App\Repositories;

use App\Repositories\Repository;

class ProductRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return 'App\Models\Product';
    }

    /**
     * Retrieve filtered collection
     *
     * @param $filters
     * @return $this
     */
    public function filter($filters)
    {
        $this->model = $this->model->filter($filters);

        return $this;
    }

    /**
     * Retrieve collection of active products
     *
     * @return $this
     */
    public function active()
    {
        $this->model = $this->model->where('status', '=' , 1);

        return $this;
    }

    /**
     * Retrieve collection of products in stock
     *
     * @return $this
     */
    public function stocked()
    {
        $this->model = $this->model->where('stock', '>', 0);

        return $this;
    }

    /**
     * Retrieve collection of products based on title or code
     *
     * @param string $input
     * @return $this
     */
    public function getByTitleOrCode($input)
    {
        $this->model = $this->model->where(function ($query) use ($input) {
            $query->where('title', 'like', '%'.$input.'%')
                ->orWhere('code', 'like', '%'.$input.'%');
        });

        return $this;
    }

    /**
     * Retrieve collection of products based on category
     *
     * @param $categoryId
     * @return $this
     */
    public function getByCategoryId($categoryId)
    {
        $this->model = $this->model->whereHas('categories', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        });

        return $this;
    }
}
