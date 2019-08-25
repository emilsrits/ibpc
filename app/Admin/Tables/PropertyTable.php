<?php

namespace App\Admin\Tables;

use App\Admin\Tables\Table;

class PropertyTable extends Table
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

    /**
     * Specify table slug
     *
     * @return string
     */
    function slug()
    {
        return 'property';
    }

    /**
     * Add columns to the table
     */
    function addColumns()
    {
        $this->columnSet->add('id', '#ID')
            ->width('100px');

        $this->columnSet->add('name', 'Name');

        $this->columnSet->add('created_at', 'Created');

        $this->columnSet->add('updated_at', 'Updated');
    }
}
