<?php

namespace App\Admin\Inputs;

use App\Admin\Inputs\Input;

class SelectInput extends Input
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Input constructor
     *
     * @param string $name
     * @param array $options
     */
    public function __construct(string $name, array $options)
    {
        parent::__construct();

        $this->name = $name;
        $this->options = $options;
    }

    /**
     * Specify input type
     *
     * @return void
     */
    public function type()
    {
        return 'select';
    }

    /**
     * Render the input view
     *
     * @return mixed
     */
    public function render()
    {
        return view('admin.table._partials.input.select', [
            'name' => $this->name,
            'options' => $this->options
        ])->render();
    }
}
