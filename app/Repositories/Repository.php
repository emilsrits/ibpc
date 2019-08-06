<?php

namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Container\Container as App;

abstract class Repository implements RepositoryInterface
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
     * Repository constructor
     *
     * @param App $app
     * @throws RepositoryException
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();

    /**
     * Make model
     *
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }

    /**
     * Retrieve all of repository
     *
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        if ($this->model instanceof Builder) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }

        return $results;
    }

    /**
     * Alias for retrieve all
     *
     * @param array $columns
     * @return mixed
     */
    public function get($columns = ['*'])
    {
        return $this->all($columns);
    }

    /**
     * Retrieve all of repository, paginated
     *
     * @param null $limit
     * @param array $columns
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*'])
    {
        $limit = is_null($limit) ? config('constants.pagination.limit', 15) : $limit;
        $results = $this->model->paginate($limit, $columns);

        return $results;
    }

    /**
     * Find data by id
     *
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * Find data by field value
     *
     * @param $column
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($column, $value, $columns = ['*'])
    {
        return $this->model->where($column, '=', $value)->first($columns);
    }

    /**
     * Create a new entity
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update entity
     *
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);

        return $model->update($data);
    }

    /**
     * Delete entity
     *
     * @param $id
     * @return integer
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Delete entity by field value
     *
     * @param $column
     * @param $value
     * @return integer
     */
    public function deleteBy($column, $value)
    {
        return $this->model->where($column, '=', $value)->delete();
    }

    /**
     * Load relations
     *
     * @param $relations
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * Order a collection by column
     *
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }
}