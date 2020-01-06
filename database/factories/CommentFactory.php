<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use App\Comment;
use App\Task;
use App\User;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->unique()->sentence,
        'creator_id' => factory(User::class),
        'task_id' => factory(Task::class)->state('new task')
    ];
});
