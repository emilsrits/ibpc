<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'title', 'parent', 'parent_id', 'status' 
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
     * Delete a category
     *
     * @param array|string $ids
     * @return bool
     */
    public function deleteCategory($ids)
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
            $category = Category::findOrFail($ids);
            if ($category->products()->first()) {
                return false;
            }
            $category->destroy($ids);
            return true;
        }
    }

    /**
     * Set category status
     *
     * @param array|string $id
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
        $specificationsGroup = collect($data)->sortBy('id');
        // Attach specifications to category
        foreach ($specificationsGroup as $specifications => $specification) {
            foreach ($specification as $key => $value) {
                if ($value) {
                    $this->specifications()->attach(['specification_id' => ['specification_id' => $value]]);
                }
            }
        }
    }

    /**
     * Update specifications of a category
     * 
     * @param array $data
     */
    public function updateSpecifications(array $data)
    {
        if ($data) {
            // Attach new specifications
            $specificationsGroup = collect($data)->sortBy('id');
            foreach ($specificationsGroup as $specifications => $specification) {
                foreach ($specification as $key => $value) {
                    $categorySpec = $this->specifications->find($value);
                    if (!$categorySpec) {
                        $this->specifications()->attach(['specification_id' => ['specification_id' => $value]]);
                        continue;
                    }
                }
            }
            // Remove unchecked values
            if ($this->specifications->first()) {
                foreach ($this->specifications as $categorySpecs) {
                    $specId = $categorySpecs->id;
                    $matchFound = false;
                    foreach ($specificationsGroup as $specifications => $specification) {
                        foreach ($specification as $key => $value) {
                            if ((int)$value === $specId) {
                                $matchFound = true;
                                continue;
                            }
                        }
                    }
                    if (!$matchFound) {
                        $this->specifications()->detach(['specification_id' => ['specification_id' => $specId]]);
                    }
                }
            }
        } else {
            // Remove all specifications
            $this->removeSpecifications();
        }
    }

    /**
     * Remove specifications of a category
     */
    public function removeSpecifications()
    {
        if ($this->specifications->first()) {
            foreach ($this->specifications as $categorySpecs) {
                $specId = $categorySpecs->id;
                $this->specifications()->detach(['specification_id' => ['specification_id' => $specId]]);
            }
        }
    }

    /**
     * Get a related specification by id
     *
     * @param string $id
     * @return mixed|null
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
    public function getSpecificationId()
    {
        return $this->specifications()->allRelatedIds();
    }

    /**
     * Set parent_id depending on parent status
     * 
     * @param integer $parent_id
     */
    public function setParentIdAttribute($parent_id)
    {
        if ($this->attributes['parent'] == '1') {
            $this->attributes['parent_id'] = null;
        } else {
            $this->attributes['parent_id'] = $parent_id;
        }
    }
}
