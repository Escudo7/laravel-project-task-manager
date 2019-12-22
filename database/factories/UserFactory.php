<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'firstname' => $faker->name,
        'lastname' => $faker->name,
        'sex' => $faker->randomElement(['male', 'female']),
        'birth_day' => $faker->numberBetween($min = 1, $max = 31),
        'birth_month' => $faker->numberBetween($min = 1, $max = 12),
        'birth_year' => $faker->numberBetween($min = 1930, $max = 2015),
        'country' => $faker->country,
        'city' => $faker->city
    ];
});
