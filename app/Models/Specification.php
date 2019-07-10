<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    /**
     * The properties that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'name'
    ];

    /**
     * OneToMany relationship with Property class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
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
     * @param array|string $ids
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
