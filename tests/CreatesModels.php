<?php

namespace Tests;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Specification;

trait CreatesModels
{
    /**
     * Make user with no roles
     *
     * @param array $attributes
     * @param integer $count
     * @return User
     */
    protected function makeUserWithNoRole(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(User::class, $count)->make(array_merge([], $attributes));
        }
        return factory(User::class)->make(array_merge([], $attributes));
    }

    /**
     * Create user with role user
     *
     * @param array $attributes
     * @param integer $count
     * @return User
     */
    protected function createUser(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(User::class, $count)->states('user')->create(array_merge([], $attributes));
        }
        return factory(User::class)->states('user')->create(array_merge([], $attributes));
    }

    /**
     * Create user with role admin
     *
     * @param array $attributes
     * @param integer $count
     * @return User
     */
    protected function createAdmin(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(User::class, $count)->states('admin')->create(array_merge([], $attributes));
        }
        return factory(User::class)->states('admin')->create(array_merge([], $attributes));
    }

    /**
     * Make user with role user
     *
     * @param array $attributes
     * @param integer $count
     * @return User
     */
    protected function makeUser(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(User::class, $count)->states('user')->make(array_merge([], $attributes));
        }
        return factory(User::class)->states('user')->make(array_merge([], $attributes));
    }

    /**
     * Make user with role admin
     *
     * @param array $attributes
     * @param integer $count
     * @return User
     */
    protected function makeAdmin(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(User::class, $count)->states('admin')->make(array_merge([], $attributes));
        }
        return factory(User::class)->states('admin')->make(array_merge([], $attributes));
    }

    /**
     * Create category
     *
     * @param array $attributes
     * @param integer $count
     * @return Category
     */
    protected function createCategory(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(Category::class, $count)->create(array_merge([], $attributes));
        }

        return factory(Category::class)->create(array_merge([], $attributes));
    }

    /**
     * Create product
     *
     * @param array $attributes
     * @param integer $count
     * @return Product
     */
    protected function createProduct(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(Product::class, $count)->create(array_merge([], $attributes));
        }

        return factory(Product::class)->create(array_merge([], $attributes));
    }

    /**
     * Create product with a new category attached
     *
     * @param array $attributes
     * @param integer $count
     * @return Product
     */
    protected function createProductWithCategory(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(Product::class, $count)->states('category')->create(array_merge([], $attributes));
        }

        return factory(Product::class)->states('category')->create(array_merge([], $attributes));
    }

    /**
     * Create specification
     *
     * @param array $attributes
     * @param integer $count
     * @return Specification
     */
    protected function createSpecification(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(Specification::class, $count)->create(array_merge([], $attributes));
        }

        return factory(Specification::class)->create(array_merge([], $attributes));
    }
}
