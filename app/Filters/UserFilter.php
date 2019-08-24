<?php

namespace App\Filters;

use App\Filters\QueryFilter;
use Illuminate\Support\Facades\DB;

class UserFilter extends QueryFilter
{
    /**
     * Filter user by id
     *
     * @param string $id
     * @return mixed
     */
    public function id($id)
    {
        return $this->builder->where('id', $id);
    }

    /**
     * Filter user by user name
     *
     * @param $user
     * @return mixed
     */
    public function name($user)
    {
        if (is_numeric($user)) {
            return $this->builder->where('id', $user);
        }

        return $this->builder->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%'.$user.'%');
    }

    /**
     * Filter user by role
     * 
     * @param $role
     * @return mixed
     */
    public function role($role)
    {
        return $this->builder->whereHas('roles', function ($query) use ($role) {
           $query->where('role_id', $role);
        });
    }

    /**
     * Filter user by status
     *
     * @param $status
     * @return mixed
     */
    public function status($status)
    {
        return $this->builder->where('status', $status);
    }

    /**
     * Sort user by created date
     *
     * @param string $order
     * @return mixed
     */
    public function created($order = 'desc')
    {
        return $this->builder->orderBy('created_at', $order);
    }

    /**
     * Filter user by created date
     *
     * @param $date
     * @return mixed
     */
    public function createdAt($date)
    {
        return $this->builder->where('created_at', 'like', '%'.$date.'%');
    }

    /**
     * Sort user by updated date
     *
     * @param string $order
     * @return mixed
     */
    public function updated($order = 'desc')
    {
        return $this->builder->orderBy('updated_at', $order);
    }

    /**
     * Filter user by updated date
     *
     * @param $date
     * @return mixed
     */
    public function updatedAt($date)
    {
        return $this->builder->where('updated_at', 'like', '%'.$date.'%');
    }
}
