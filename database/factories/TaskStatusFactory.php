<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\TaskStatus;

$factory->define(TaskStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});