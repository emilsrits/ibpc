<?php

namespace App\Admin\Columns;

use App\Admin\Inputs\Input;
use Illuminate\Support\Collection;

class ColumnSet
{
    /**
     * @var array
     */
    public $list;

    /**
     * @var string
     */
    public $column;

    /**
     * @var bool
     */
    public $hasFilters = false;

    /**
     * ColumnSet constructor
     * 
     */
    public function __construct()
    {
        $this->list = new Collection();
    }

    /**
     * Add a column to column list
     *
     * @param string $column
     * @param mixed $name
     * @return $this
     */
    public function add(string $column, $name = null)
    {
        $this->list->push([
            'column'    => $column,
            'name'      => $name ?? $column,
            'filter'    => null,
            'width'     => null
        ]);

        $this->column = $column;

        return $this;
    }

    /**
     * Add filter to a column
     *
     * @param Input $type
     * @return mixed
     */
    public function filter(Input $type)
    {
        if ($this->column === null) {
            return $this;
        }

        $this->list = $this->list->map(function ($item) use ($type) {
            if ($this->column === $item['column']) {
                $item['filter'] = $type;
            }

            if (!$this->hasFilters) {
                $this->hasFilters = true;
            }

            return $item;
        });

        return $this;
    }

    /**
     * Set width of a column
     *
     * @param string $width
     * @return mixed
     */
    public function width(string $width = '150px')
    {
        $this->list = $this->list->map(function ($item) use ($width) {
            if ($this->column === $item['column']) {
                $item['width'] = $width;
            }

            return $item;
        });

        return $this;
    }
}
