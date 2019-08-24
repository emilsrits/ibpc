<?php

namespace App\Traits;

trait HasStatus
{
    /**
     * Return readable status instead of an integer
     *
     * @return string
     */
    public function getFullStatusAttribute()
    {
        return $this->status ? 'Enabled' : 'Disabled';
    }
}
