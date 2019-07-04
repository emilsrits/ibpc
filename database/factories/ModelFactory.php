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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;
    
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'status' => '1',
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

$factory->define(App\Models\Role::class, function(Faker\Generator $faker) {
    $word = $faker->word;

    return [
        'name' => $word,
        'slug' => $word,
        'description' => $faker->text(10),
    ];
});