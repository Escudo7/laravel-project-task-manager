<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Task;
use App\User;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(),
        'description' => $faker->sentence(),
        'creator_id' => factory(User::class),
    ];
});

$factory->state(Task::class, 'new task', [
    'status_id' => 1,
]);

$factory->state(Task::class, 'working', [
    'status_id' => 2,
]);

$factory->state(Task::class, 'testing', [
    'status_id' => 3,
]);

$factory->state(Task::class, 'terminated', [
    'status_id' => 4,
]);
