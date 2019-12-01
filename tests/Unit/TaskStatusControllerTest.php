<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Task;
use App\TaskStatus;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        factory(User::class)->create();
    }
    
    public function testIndex()
    {
        $response = $this->actingAs(User::first())
            ->get(route('task_statuses.index'));
        $response->assertStatus(200);
        $this->assertEquals(4, TaskStatus::count());
    }

    public function testStore()
    {
        $date = ['name' => 'new status test'];
        $response = $this->actingAs(User::first())
            ->post(route('task_statuses.store'), $date);
        $response->assertStatus(302);
        $this->assertEquals(5, TaskStatus::count());
        $this->assertDatabaseHas('task_statuses', $date);
    }

    public function testUpdate()
    {
        $date = TaskStatus::find(1)->toArray();
        $date['name'] = 'new status test';
        $response = $this->actingAs(User::first())
            ->patch(route('task_statuses.update', TaskStatus::find(1)), $date);
        $response->assertStatus(302);
        $this->assertEquals(4, TaskStatus::count());
        $this->assertDatabaseHas('task_statuses', $date);
    }

    public function testDestroy()
    {
        $response = $this->actingAs(User::first())
            ->delete(route('task_statuses.destroy', TaskStatus::find(1)));
        $response->assertStatus(302);
        $this->assertEquals(3, TaskStatus::count());
    }

    public function testDestroyWithDate()
    {
        factory(Task::class)->state('new task')->create();
        $response = $this->actingAs(User::first())
            ->delete(route('task_statuses.destroy', TaskStatus::find(1)));
        $response->assertStatus(302);
        $this->assertEquals(4, TaskStatus::count());
    }
}
