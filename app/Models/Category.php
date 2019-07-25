<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The properties that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'top_level', 'parent_id', 'status' 
    ];

    /**
     * These relationships should be auto loaded
     *
     * @var array
     */
    protected $with = [
        'specifications'
    ];

    /**
     * ManyToMany relationship with Product class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    /**
     * ManyToMany relationship with Specification class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'category_specification', 'category_id', 'specification_id');
    }

    /**
     * OneToMany relationship with Category class
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * OneToMany relationship with Category class
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Query to only include category with matching slug
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * Query to only include top level categories
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTop($query)
    {
        return $query->where('top_level', 1);
    }

    /**
     * Query to only include child categories
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeChild($query)
    {
        return $query->where('top_level', 0);
    }

    /**
     * Query to only include active categories
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Delete a category
     *
     * @param mixed $ids
     * @return bool
     */
    public function deleteCategory($ids = null)
    {
        if (is_array($ids)) {
            foreach ($ids as $id => $value) {
                $category = Category::find($id);
                if ($category->products()->first()) {
                    return false;
                }
                $category->destroy($id);
                return true;
            }
        } else {
            if ($this->products()->first()) {
                return false;
            }
            $this->destroy($this->id);
            return true;
        }
    }

    /**
     * Set category status
     *
     * @param mixed $id
     * @param $status
     */
    public function setStatus($id, $status)
    {
        if (is_array($id)) {
            foreach ($id as $productId => $value) {
                $category = Category::find($value['id']);
                $category->status = $status;
                $category->save();
            }
        } else {
            $category = Category::findOrFail($id);
            $category->status = $status;
            $category->save();
        }
    }

    /**
     * Set specifications of a category
     * 
     * @param array $data
     */
    public function setSpecifications(array $data)
    {
        $this->specifications()->attach(array_column($data, 'id'));
    }

    /**
     * Update specifications of a category
     * 
     * @param array $data
     */
    public function updateSpecifications(array $data)
    {
        $this->specifications()->sync(array_column($data, 'id'));
    }

    /**
     * Get a category with specifications and properties by id
     *
     * @param string $id
     * @return Category
     */
    public function getCategoryWithPropertiesById($id)
    {
        return $this->with('specifications.properties')->find($id);
    }

    /**
     * Get a related specification by id
     *
     * @param string $id
     * @return mixed
     */
    public function getSpecificationById($id)
    {
        $specification = $this->specifications()->find($id);
        if ($specification) {
            $value = $specification->name;
        } else {
            $value = null;
        }

        return $value;
    }

    /**
     * Get related specification ids
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSpecificationIds()
    {
        return $this->specifications()->allRelatedIds();
    }

    /**
     * Set parent_id depending on top_level status
     * 
     * @param integer $parentId
     */
    public function setParentIdAttribute($parentId)
    {
        if ($this->attributes['top_level'] == '1') {
            $this->attributes['parent_id'] = null;
        } else {
            $this->attributes['parent_id'] = $parentId;
        }
    }

    /**
     * Mutator for category title attribute
     *
     * @param string $title
     */
    public function setTitleAttribute($title)
    {
        $this->attributes['slug'] = str_slug($title);
        $this->attributes['title'] = $title;
    }
}
