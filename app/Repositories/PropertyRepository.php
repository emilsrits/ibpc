<?php

namespace App\Repositories;

use App\Repositories\Repository;

class PropertyRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return 'App\Models\Property';
    }
}
