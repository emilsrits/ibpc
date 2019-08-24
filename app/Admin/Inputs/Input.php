<?php

namespace App\Admin\Inputs;

abstract class Input
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * Input constructor
     */
    public function __construct()
    {
        $this->setType();
    }

    /**
     * Specify input type
     *
     * @return void
     */
    abstract function type();

    /**
     * Render the input view
     *
     * @return mixed
     */
    abstract function render();

    /**
     * Set input type
     */
    public function setType()
    {
        $this->type = $this->type();
    }
}
