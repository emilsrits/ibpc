<?php

namespace App\Contracts;

interface TableInterface
{
    /**
     * Render the table view
     *
     * @param mixed $collection
     * @return mixed
     */
    public function render($collection);
}