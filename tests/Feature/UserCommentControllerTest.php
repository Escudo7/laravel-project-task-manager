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
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $task = factory(Task::class)->state('new task')->create();
        $modelComment = factory(Comment::class)->make();
        
        $this->post(route('users.comments.store', $user), $modelComment->toArray());
        $this->assertEquals(1, Comment::count());
    }
}
