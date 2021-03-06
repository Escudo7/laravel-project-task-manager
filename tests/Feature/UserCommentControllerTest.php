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
        $task = factory(Task::class)->state('new task')->create();
        $user = User::first();
        $this->actingAs($user);
        $modelComment = factory(Comment::class)->make();
        
        $response = $this->post(route('users.comments.store', $user), $modelComment->toArray());
        $response->assertStatus(302);
        $this->assertEquals(1, Comment::where('body', $modelComment->body)->count());
    }
}
