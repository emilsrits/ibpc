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
     * @param $user
     * @return mixed
     */
    public function user($user)
    {
        if (is_numeric($user)) {
            return $this->builder->where('id', $user);
        }

        return $this->builder->whereHas('user', function ($query) use ($user) {
           $query->where('name', 'like', '%'.$user.'%')
               ->orWhere('surname', 'like', '%'.$user.'%')
               ->orWhere(DB::raw('CONCAT_WS(" ", name, surname)'), 'like', $user);
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
