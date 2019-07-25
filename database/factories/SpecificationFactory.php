<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Specification::class, function (Faker $faker) {
    $name = trim(substr($faker->unique()->sentence(rand(1, 4)), 0, 50), '.');
    $slug = str_slug($name);

    return [
        'slug' => $slug,
        'name' => $name,
    ];
});
