<?php

namespace App\Repositories;

use App\Repositories\Repository;

class CategoryRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Category';
    }

    /**
     * Retrieve collection of active categories
     *
     * @return $this
     */
    public function active()
    {
        $this->model = $this->model->where('status', '=' , 1);

        return $this;
    }

    /**
     * Retrieve collection of parent categories
     *
     * @return $this
     */
    public function parent()
    {
        $this->model = $this->model->where('top_level', '=', 1);

        return $this;
    }

    /**
     * Retrieve collection of child categories
     *
     * @return $this
     */
    public function child()
    {
        $this->model = $this->model->where('top_level', '=' , 0);

        return $this;
    }
}
