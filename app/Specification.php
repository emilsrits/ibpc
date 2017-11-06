<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    /**
     * OneToMany relationship with Attribute class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    /**
     * ManyToMany relationship with Category class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_specification', 'specification_id', 'category_id');
    }

    /**
     * Delete specification
     *
     * @param $ids
     */
    public function deleteSpecification($ids)
    {
        if (is_array($ids)) {
            foreach ($ids as $id => $value) {
                $specification = Specification::find($id);
                $specification->destroy($id);
            }
        } else {
            $specification = Specification::findOrFail($ids);
            $specification->destroy($ids);
        }
    }
}
