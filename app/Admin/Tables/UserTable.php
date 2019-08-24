<?php

namespace App\Admin\Tables;

use App\Admin\Inputs\NumberInput;
use App\Admin\Inputs\SelectInput;
use App\Admin\Inputs\TextInput;
use App\Admin\Tables\Table;

class UserTable extends Table
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return 'App\Models\User';
    }

    /**
     * Specify table slug
     *
     * @return string
     */
    function slug()
    {
        return 'user';
    }

    /**
     * Add columns to the table
     */
    function addColumns()
    {
        $this->columnSet->add('id', '#ID')
            ->filter(new NumberInput('id'))
            ->width('100px');

        $this->columnSet->add('full_name', 'Name')
            ->filter(new TextInput('name'));
        
        $this->columnSet->add('main_role', 'Role')
            ->filter(new SelectInput('role', array_flip(config('constants.user_roles'))));

        $this->columnSet->add('full_status', 'Status')
            ->filter(new SelectInput('status', [
                '1' => 'Enabled',
                '0' => 'Disabled'
            ]));

        $this->columnSet->add('created_at', 'Created')
            ->filter(new TextInput('createdAt'));

        $this->columnSet->add('updated_at', 'Updated')
            ->filter(new TextInput('updatedAt'));
    }
}
