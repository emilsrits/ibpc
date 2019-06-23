<?php

namespace App\Filters;

use App\Filters\QueryFilter;

class ProductFilter extends QueryFilter
{
    /**
     * Filter product by id
     *
     * @param string $id
     * @return mixed
     */
    public function id($id)
    {
        return $this->builder->where('id', $id);
    }

    /**
     * Filter product by title
     *
     * @param $title
     * @return mixed
     */
    public function title($title)
    {
        return $this->builder->where('title', 'like', '%'.$title.'%');
    }

    /**
     * Filter product by code
     *
     * @param $code
     * @return mixed
     */
    public function code($code)
    {
        return $this->builder->where('code', 'like', '%'.$code.'%');
    }

    /**
     * Filter product by status
     *
     * @param $status
     * @return mixed
     */
    public function status($status)
    {
        if ($status) {
            if ($status === 'enabled') {
                $status = 1;
            }
            if ($status === 'disabled') {
                $status = 0;
            }
        }
        return $this->builder->where('status', strtolower($status));
    }

    /**
     * Filter product by category
     *
     * @param $category
     * @return mixed
     */
    public function category($category)
    {
        return $this->builder->whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category);
        });
    }

    /**
     * Sort product by created date
     *
     * @param string $order
     * @return mixed
     */
    public function created($order = 'desc')
    {
        return $this->builder->orderBy('created_at', $order);
    }

    /**
     * Filter product by created date
     *
     * @param $date
     * @return mixed
     */
    public function createdAt($date)
    {
        return $this->builder->where('created_at', 'like', '%'.$date.'%');
    }

    /**
     * Sort product by updated date
     *
     * @param string $order
     * @return mixed
     */
    public function updated($order = 'desc')
    {
        return $this->builder->orderBy('updated_at', $order);
    }

    /**
     * Filter product by updated date
     *
     * @param $date
     * @return mixed
     */
    public function updatedAt($date)
    {
        return $this->builder->where('updated_at', 'like', '%'.$date.'%');
    }
}
