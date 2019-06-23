<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected $request;

    protected $builder;

    /**
     * QueryFilter constructor
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply filters
     *
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name)) {
                if ($value || $value === '0') {
                    call_user_func_array([$this, $name], array_filter([$value], 'strlen'));
                }
            }
        }

        return $this->builder;
    }

    /**
     * Get filters
     *
     * @return array
     */
    public function filters()
    {
        return $this->request->except('_token', 'submit', 'mass-action');
    }
}
