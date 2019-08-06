<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Category::class, function (Faker $faker) {
    $faker->seed(rand());
    $title = trim(substr($faker->unique()->sentence(rand(2, 4)), 0, 50), '.');
    $slug = str_slug($title);

    return [
        'title' => $title,
        'slug' => $slug,
        'top_level' => 1,
        'parent_id' => null,
        'status' => 1,
    ];
});
