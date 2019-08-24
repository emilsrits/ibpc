<?php

namespace App\Admin\Inputs;

use App\Admin\Inputs\Input;

class TextInput extends Input
{
    /**
     * Input constructor
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct();

        $this->name = $name;
    }

    /**
     * Specify input type
     *
     * @return void
     */
    public function type()
    {
        return 'text';
    }

    /**
     * Render the input view
     *
     * @return mixed
     */
    public function render()
    {
        return view('admin.table._partials.input.text', [
            'name' => $this->name
        ])->render();
    }
}
