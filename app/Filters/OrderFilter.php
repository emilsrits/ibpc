<?php

namespace App\Filters;

use App\Filters\QueryFilter;
use Illuminate\Support\Facades\DB;

class OrderFilter extends QueryFilter
{
    /**
     * Filter order by id
     *
     * @param string $id
     * @return mixed
     */
    public function id($id)
    {
        return $this->builder->where('id', $id);
    }

    /**
     * Filter order by user name
     *
     * @param $user
     * @return mixed
     */
    public function user($user)
    {
        if (is_numeric($user)) {
            return $this->builder->where('id', $user);
        }

        return $this->builder->whereHas('user', function ($query) use ($user) {
           $query->where('first_name', 'like', '%'.$user.'%')
               ->orWhere('last_name', 'like', '%'.$user.'%')
               ->orWhere(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', $user);
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
     * Sort order by created date
     *
     * @param string $order
     * @return mixed
     */
    public function created($order = 'desc')
    {
        return $this->builder->orderBy('created_at', $order);
    }

    /**
     * Filter by created date
     *
     * @param $date
     * @return mixed
     */
    public function createdAt($date)
    {
        return $this->builder->where('created_at', 'like', '%'.$date.'%');
    }

    /**
     * Sort order by updated date
     *
     * @param string $order
     * @return mixed
     */
    public function updated($order = 'desc')
    {
        return $this->builder->orderBy('updated_at', $order);
    }

    /**
     * Filter by updated date
     *
     * @param $date
     * @return mixed
     */
    public function updatedAt($date)
    {
        return $this->builder->where('updated_at', 'like', '%'.$date.'%');
    }
}
