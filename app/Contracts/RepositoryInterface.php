<?php

namespace App\Contracts;

interface RepositoryInterface
{
    /**
     * Retrieve all of repository
     *
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ['*']);

    /**
     * Alias for retrieve all
     *
     * @param array $columns
     * @return mixed
     */
    public function get(array $columns = ['*']);

    /**
     * Retrieve all of repository, paginated
     *
     * @param null $limit
     * @param array $columns
     * @return mixed
     */
    public function paginate($limit = null, array $columns = ['*']);

    /**
     * Find data by id
     *
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, array $columns = ['*']);

    /**
     * Find data by field value
     *
     * @param $column
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($column, $value, array $columns = ['*']);

    /**
     * Create a new entity
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update entity
     *
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * Delete entity
     *
     * @param $id
     * @return integer
     */
    public function delete($id);

    /**
     * Delete entity by field value
     *
     * @param $column
     * @param $value
     * @return integer
     */
    public function deleteBy($column, $value);

    /**
     * Load relations
     *
     * @param $relations
     * @return $this
     */
    public function with($relations);

    /**
     * Add count of relations to collection
     *
     * @param mixed $relations
     * @return $this
     */
    public function withCount($relations);

    /**
     * Load where model has relations
     *
     * @param string $relations
     * @return $this
     */
    public function has(string $relation);

    /**
     * Load relation with closure
     *
     * @param string $relation
     * @param $closure
     * @return $this
     */
    public function whereHas(string $relation, $closure);

    /**
     * Order a collection by column
     *
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc');

    /**
     * Limit how many entries to retrieve
     *
     * @param integer $limit
     * @return $this
     */
    public function take(int $limit);
}
