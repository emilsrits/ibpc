<?php

namespace App\Admin\Tables;

use App\Admin\Columns\ColumnSet;
use App\Contracts\TableInterface;
use App\Exceptions\TableException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Table implements TableInterface
{
    /**
     * @var App
     */
    protected $app;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var ColumnSet
     */
    protected $columnSet;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var bool
     */
    public $paginated = false;

    /**
     * Table constructor
     * 
     * @param App $app
     * @throws TableException
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
        $this->makeColumnSet();
        $this->setSlug();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract function model();

    /**
     * Add columns to table
     */
    abstract function addColumns();

    /**
     * Specify table slug
     *
     * @return string
     */
    abstract function slug();

    /**
     * Make model
     *
     * @return Model
     * @throws TableException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new TableException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        
        $this->model = $model;
    }

    /**
     * Make set of columns
     *
     * @return void
     */
    public function makeColumnSet()
    {
        $this->columnSet = new ColumnSet();
        $this->addColumns();
    }

    /**
     * Render the table view
     *
     * @param mixed $collection
     * @return mixed
     */
    public function render($collection)
    {
        if (!$collection instanceof Collection && !$collection instanceof LengthAwarePaginator) {
            throw new TableException(
                "Parameter must be an instance of Illuminate\\Database\\Eloquent\\Collection
                    or Illuminate\\Pagination\\LengthAwarePaginator"
            );
        }

        if ($collection instanceof LengthAwarePaginator) {
            $this->paginated = true;
        }

        return view('admin.table.index', [
            'table' => $this,
            'collection' => $collection
        ])->render();
    }

    /**
     * Return array of table columns
     *
     * @return Collection
     */
    public function getColumns()
    {
        return $this->columnSet->list;
    }

    /**
     * Check if table has columns with filters and return boolean
     *
     * @return boolean
     */
    public function hasFilters()
    {
        return $this->columnSet->hasFilters;
    }

    /**
     * Set table slug value
     */
    public function setSlug()
    {
        $this->slug = $this->slug();
    }
}
