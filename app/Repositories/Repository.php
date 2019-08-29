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
     * @return string
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

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Reset model
     *
     * @throws RepositoryException
     */
    public function resetModel()
    {
        $this->makeModel();
    }

    /**
     * Retrieve all of repository
     *
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ['*'])
    {
        if ($this->model instanceof Builder) {
            $result = $this->model->get($columns);
        } else {
            $result = $this->model->all($columns);
        }

        $this->resetModel();

        return $result;
    }

    /**
     * Alias for retrieve all
     *
     * @param array $columns
     * @return mixed
     */
    public function get(array $columns = ['*'])
    {
        $result = $this->all($columns);

        $this->resetModel();

        return $result;
    }

    /**
     * Retrieve all of repository, paginated
     *
     * @param null $limit
     * @param array $columns
     * @return mixed
     */
    public function paginate($limit = null, array $columns = ['*'])
    {
        if (is_null($limit)) {
            $limit = session('page-size') ?? config('constants.pagination.limit', 15);
        }

        $result = $this->model->paginate($limit, $columns);

        $this->resetModel();

        return $result;
    }

    /**
     * Find data by id
     *
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, array $columns = ['*'])
    {
        $result = $this->model->findOrFail($id, $columns);

        $this->resetModel();

        return $result;
    }

    /**
     * Find data by field value
     *
     * @param $column
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($column, $value, array $columns = ['*'])
    {
        $result = $this->model->where($column, '=', $value)->first($columns);

        $this->resetModel();

        return $result;
    }

    /**
     * Create a new entity
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $result = $this->model->create($data);

        $this->resetModel();

        return $result;
    }

    /**
     * Update entity
     *
     * @param array $data
     * @param $id Entity model or ID
     * @return mixed
     */
    public function update(array $data, $id)
    {
        if ($id instanceof Model) {
            $model = $id;
        } else {
            $model = $this->model->findOrFail($id);
        }

        $result = $model->update($data);

        $this->resetModel();

        return $result;
    }

    /**
     * Delete entity
     *
     * @param $id
     * @return integer
     */
    public function delete($id)
    {
        if (is_array($id)) {
            foreach ($id as $key => $value) {
                $result = $this->model->destroy($key);
            }
        } else {
            $result = $this->model->destroy($id);
        }

        $this->resetModel();

        return $result;
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
        $result = $this->model->where($column, '=', $value)->delete();

        $this->resetModel();

        return $result;
    }

    /**
     * Load relations
     *
     * @param mixed $relations
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    /**
     * Add count of relations to collection
     *
     * @param mixed $relations
     * @return $this
     */
    public function withCount($relations)
    {
        $this->model = $this->model->withCount($relations);

        return $this;
    }

    /**
     * Load where model has relations
     *
     * @param string $relations
     * @return $this
     */
    public function has(string $relation)
    {
        $this->model = $this->model->has($relation);

        return $this;
    }

    /**
     * Load relation with closure
     *
     * @param string $relation
     * @param $closure
     * @return $this
     */
    public function whereHas(string $relation, $closure)
    {
        $this->model = $this->model->whereHas($relation, $closure);

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

    /**
     * Limit how many entries to retrieve
     *
     * @param integer $limit
     * @return $this
     */
    public function take(int $limit)
    {
        $this->model = $this->model->take($limit);

        return $this;
    }
}
