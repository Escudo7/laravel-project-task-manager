<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Task;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(),
        'description' => $faker->sentence(),
        'creator_id' => 1,
    ];
});

$factory->state(Task::class, 'new task', [
    'status_id' => 1,
]);

$factory->state(Task::class, 'working', [
    'status_id' => 2,
]);
