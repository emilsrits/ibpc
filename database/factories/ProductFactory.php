<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    $title = trim(substr($faker->unique()->sentence(rand(1, 4)), 0, 50), '.');
    $code = str_slug($title);

    return [
        'code' => $code,
        'title' => $title,
        'description' => $faker->text(100),
        'price' => $faker->randomNumber(5) + 3000,
        'price_old' => null,
        'stock' => $faker->numberBetween(0, 100),
        'status' => 1,
    ];
});

$factory->state(App\Models\Product::class, 'category', [])
    ->afterCreatingState(App\Models\Product::class, 'category', function ($product) {
        $product->categories()->attach(factory(App\Models\Category::class)->create());
    });
