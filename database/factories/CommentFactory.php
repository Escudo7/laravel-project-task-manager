<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use App\Comment;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->unique()->sentence,
        'creator_id' => 1,
        'task_id' => 1
    ];
});
