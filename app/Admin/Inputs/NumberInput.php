<?php

namespace App\Admin\Inputs;

use App\Admin\Inputs\Input;

class NumberInput extends Input
{
    /**
     * @var array
     */
    protected $min;

    /**
     * @var array
     */
    protected $max;

    /**
     * Input constructor
     *
     * @param string $name
     * @param mixed $min
     * @param mixed $max
     */
    public function __construct(string $name, $min = 1, $max = null)
    {
        parent::__construct();

        $this->name = $name;
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Specify input type
     *
     * @return void
     */
    public function type()
    {
        return 'number';
    }

    /**
     * Render the input view
     *
     * @return mixed
     */
    public function render()
    {
        return view('pages.admin.table._partials.input.number', [
            'name' => $this->name,
            'min' => $this->min,
            'max' => $this->max
        ])->render();
    }
}
