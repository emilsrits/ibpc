<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
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
        return $this->belongsToMany(Specification::class, 'category_specification');
    }

    /**
     * Delete a category
     *
     * @param $ids
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
     * @param $id
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
     * Get a related specification by id
     *
     * @param $id
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
        return $this->specifications()->getRelatedIds();
    }
}
