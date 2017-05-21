<?php

namespace App\Filters;

use App\Filters\QueryFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class OrderFilter extends QueryFilter
{
    /**
     * Filter order by id
     *
     * @param $id
     * @return mixed
     */
    public function id($id)
    {
        return $this->builder->where('id', $id);
    }

    /**
     * Filter order by user name
     *
     * @param $name
     * @return mixed
     */
    public function name($name)
    {
        return $this->builder->whereHas('user', function ($query) use ($name) {
           $query->where('name', $name)
               ->orWhere('surname', $name)
               ->orWhere(DB::raw('CONCAT_WS(" ", name, surname)'), 'like', $name);
        });
    }

    /**
     * Filter order by status
     *
     * @param $status
     * @return mixed
     */
    public function status($status)
    {
        return $this->builder->where('status', strtolower($status));
    }

    /**
     * Filter order by created date
     *
     * @param string $order
     * @return mixed
     */
    public function created($order = 'desc')
    {
        return $this->builder->orderBy('created_at', $order);
    }

    /**
     * Filter order by updated date
     *
     * @param string $order
     * @return mixed
     */
    public function updated($order = 'desc')
    {
        return $this->builder->orderBy('updated_at', $order);
    }
}
