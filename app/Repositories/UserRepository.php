<?php

namespace App\Repositories;

use App\Repositories\Repository;

class UserRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\User';
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
}
