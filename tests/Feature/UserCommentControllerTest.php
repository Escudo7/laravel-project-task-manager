<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;
use App\User;
use App\Comment;

class UserCommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        factory(User::class)->create();
        factory(Task::class)->state('new task')->create();
        $user = User::first();
        $task = Task::first();

        $dataToCreate = [
            'body' => \Faker\Factory::create()->text(20),
            'task_id' => $task->id
        ];

        $route = route('users.comments.store', $user);
        $this->actingAs($user)->post($route, $dataToCreate);

        $this->assertEquals(1, Comment::count());

        $comment = Comment::first();
        $dataComment = [
            'body' => $comment->body,
            'task_id' => $comment->task->id
        ];
        $this->assertEquals($dataToCreate, $dataComment);
    }
}
