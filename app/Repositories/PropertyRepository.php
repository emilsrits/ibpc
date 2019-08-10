<?php

namespace App\Repositories;

use App\Repositories\Repository;

class PropertyRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Property';
    }
}
