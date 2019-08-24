<?php

namespace App\Traits;

trait HasPrice
{
    /**
     * Get old price attribute
     *
     * @return string
     */
    public function getOldPriceAttribute()
    {
    	if ($this->price_old) {
            return ($this->price_old);
        }
        
        return  '';
    }

    /**
     * Get current price attribute
     *
     * @return string
     */
    public function getCurrentPriceAttribute()
    {
    	return $this->price;
    }

    /**
     * Get parsed price attribute
     *
     * @return string
     */
    public function getPriceParsedAttribute()
    {
        return money($this->price);
    }

    /**
     * Get parsed old price attribute
     *
     * @return string
     */
    public function getPriceOldParsedAttribute()
    {
        return money($this->price_old);
    }
}
