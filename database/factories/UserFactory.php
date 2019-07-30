<?php

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('password'),
        'status' => '1',
        'phone' => $faker->phoneNumber,
        'country' => $faker->countryCode,
        'city' => $faker->city,
        'address' => $faker->address,
        'postcode' => $faker->postcode,
    ];
});

$factory->state(App\Models\User::class, 'user', [])
    ->afterCreatingState(App\Models\User::class, 'user', function ($user) {
        $user->roles()->attach(config('constants.user_roles.user'));
    });

$factory->state(App\Models\User::class, 'admin', [])
    ->afterCreatingState(App\Models\User::class, 'admin', function ($user) {
        $user->roles()->attach(config('constants.user_roles.admin'));
    });