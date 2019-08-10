<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Repository;

class OrderRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Order';
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
     * Retrieve collection of active orders
     *
     * @return $this
     */
    public function active()
    {
        $this->model = $this->model->whereIn('status', config('constants.order_status_active'));

        return $this;
    }

    /**
     * Retrieve collection of finished orders
     *
     * @return $this
     */
    public function finished()
    {
        $this->model = $this->model->whereIn('status', config('constants.order_status_finished'));

        return $this;
    }
}
