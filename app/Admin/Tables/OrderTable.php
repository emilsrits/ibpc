<?php

namespace App\Admin\Tables;

use App\Admin\Inputs\NumberInput;
use App\Admin\Inputs\SelectInput;
use App\Admin\Inputs\TextInput;
use App\Admin\Tables\Table;

class OrderTable extends Table
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return 'App\Models\Order';
    }

    /**
     * Specify table slug
     *
     * @return string
     */
    function slug()
    {
        return 'order';
    }

    /**
     * Add columns to the table
     */
    function addColumns()
    {
        $this->columnSet->add('id', '#ID')
            ->filter(new NumberInput('id'))
            ->width('100px');

        $this->columnSet->add('user_full_name', 'User')
            ->filter(new TextInput('user'));

        $this->columnSet->add('price_parsed', 'Cost');

        $this->columnSet->add('status', 'Status')
            ->filter(new SelectInput('status', config('constants.order_status')));

        $this->columnSet->add('created_at', 'Created')
            ->filter(new TextInput('createdAt'));

        $this->columnSet->add('updated_at', 'Updated')
            ->filter(new TextInput('updatedAt'));
    }
}
