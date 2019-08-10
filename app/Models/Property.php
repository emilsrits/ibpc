<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /**
     * The properties that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'specification_id', 'name'
    ];

    /**
     * All of the relationships to be touched
     *
     * @var array
     */
    protected $touches = ['specification'];
    
    /**
     * ManyToMany relationship with Product class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_property');
    }

    /**
     * OneToMany inverse relationship with Specification class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }
}
