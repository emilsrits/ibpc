<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    
    return [
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'status' => '1',
    ];
});

$factory->state(App\User::class, 'user', [])
    ->afterCreatingState(App\User::class, 'user', function ($user) {
        $user->roles()->attach(config('constants.user_roles.user'));
    });

$factory->state(App\User::class, 'admin', [])
    ->afterCreatingState(App\User::class, 'admin', function ($user) {
        $user->roles()->attach(config('constants.user_roles.admin'));
    });

$factory->define(App\Role::class, function(Faker\Generator $faker) {
    $word = $faker->word;

    return [
        'name' => $word,
        'slug' => $word,
        'description' => $faker->text(10),
    ];
});