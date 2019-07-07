<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Role::class, function(Faker $faker) {
    $word = $faker->unique()->word;

    return [
        'name' => $word,
        'slug' => str_slug($word),
    ];
});