<?php

namespace App\Admin\Tables;

use App\Admin\Tables\Table;

class CategoryTable extends Table
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return 'App\Models\Category';
    }

    /**
     * Specify table slug
     *
     * @return string
     */
    function slug()
    {
        return 'category';
    }

    /**
     * Add columns to the table
     */
    function addColumns()
    {
        $this->columnSet->add('id', '#ID')
            ->width('100px');

        $this->columnSet->add('title', 'Title');

        $this->columnSet->add('top', 'Top Category');

        $this->columnSet->add('parent_id', 'Parent #ID');

        $this->columnSet->add('full_status', 'Status');

        $this->columnSet->add('created_at', 'Created');

        $this->columnSet->add('updated_at', 'Updated');
    }
}
