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
        $date = ['body' => 'new comment', 'task_id' => 1];
        $this->actingAs(User::first())
            ->post(route('users.comments.store', User::first()), $date);
        $this->assertEquals(1, Comment::count());
    }
}
