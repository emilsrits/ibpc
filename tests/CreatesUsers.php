<?php

namespace Tests;

use App\Models\User;

trait CreatesUsers
{
    protected function makeUserWithNoRole(array $attributes = [])
    {
        return factory(User::class)->make(array_merge([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }

    protected function createUser(array $attributes = [])
    {
        return factory(User::class)->states('user')->create(array_merge([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }

    protected function createAdmin(array $attributes = [])
    {
        return factory(User::class)->states('admin')->create(array_merge([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }

    protected function makeUser(array $attributes = [])
    {
        return factory(User::class)->states('user')->make(array_merge([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }

    protected function makeAdmin(array $attributes = [])
    {
        return factory(User::class)->states('admin')->make(array_merge([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }
}
