<?php

namespace Tests;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;

trait CreatesModels
{
    protected function makeUserWithNoRole(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(User::class, $count)->make(array_merge([], $attributes));
        }
        return factory(User::class)->make(array_merge([], $attributes));
    }

    protected function createUser(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(User::class, $count)->states('user')->create(array_merge([], $attributes));
        }
        return factory(User::class)->states('user')->create(array_merge([], $attributes));
    }

    protected function createAdmin(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(User::class, $count)->states('admin')->create(array_merge([], $attributes));
        }
        return factory(User::class)->states('admin')->create(array_merge([], $attributes));
    }

    protected function makeUser(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(User::class, $count)->states('user')->make(array_merge([], $attributes));
        }
        return factory(User::class)->states('user')->make(array_merge([], $attributes));
    }

    protected function makeAdmin(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(User::class, $count)->states('admin')->make(array_merge([], $attributes));
        }
        return factory(User::class)->states('admin')->make(array_merge([], $attributes));
    }

    protected function createCategory(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(Category::class, $count)->create(array_merge([], $attributes));
        }

        return factory(Category::class)->create(array_merge([], $attributes));
    }

    protected function createProduct(array $attributes = [], $count = 1)
    {
        if ($count > 1) {
            return factory(Product::class, $count)->create(array_merge([], $attributes));
        }

        return factory(Product::class)->states('category')->create(array_merge([], $attributes));
    }
}
