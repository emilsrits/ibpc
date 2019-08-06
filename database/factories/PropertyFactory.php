<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Property::class, function (Faker $faker) {
    $name = trim(substr($faker->unique()->sentence(rand(2, 4)), 0, 50), '.');

    return [
        'name' => $name
    ];
});
