<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
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
     * ManyToOne relationship with Specification class
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
     * @param $ids
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
