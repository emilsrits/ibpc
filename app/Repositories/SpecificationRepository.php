<?php

namespace App\Repositories;

use App\Repositories\Repository;

class SpecificationRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return 'App\Models\Specification';
    }
}
