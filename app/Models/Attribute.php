<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    /**
     * The attributes that are mass assignable
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
        return $this->belongsToMany(Product::class, 'attribute_product');
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

    /**
     * Delete attributes
     *
     * @param array|string $ids
     */
    public function deleteAttribute($ids)
    {
        if (is_array($ids)) {
            foreach ($ids as $id => $value) {
                $attribute = Attribute::find($id);
                $attribute->destroy($id);
            }
        } else {
            $attribute = Attribute::findOrFail($ids);
            $attribute->destroy($ids);
        }
    }
}
