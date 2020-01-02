<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
        $this->status = TaskStatus::first();
    }
    
    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertStatus(200)
            ->assertSee($this->status->name);
    }

    public function testStore()
    {
        $modelNewStatus = factory(TaskStatus::class)->make();
        $response = $this->post(route('task_statuses.store'), $modelNewStatus->toArray());
        $response->assertStatus(302);
        $this->assertEquals(1, TaskStatus::where('name', $modelNewStatus->name)->count());
    }

    public function testUpdate()
    {
        $modelNewStatus = factory(TaskStatus::class)->make();
        $response = $this->patch(route('task_statuses.update', $this->status), $modelNewStatus->toArray());
        $response->assertStatus(302);
        $this->status->refresh();
        $this->assertEquals($modelNewStatus->name, $this->status->name);
    }

    public function testDestroy()
    {
        $response = $this->delete(route('task_statuses.destroy', $this->status));
        $response->assertStatus(302);
        $this->assertEquals(3, TaskStatus::count());
    }

    public function testDestroyWithDate()
    {
        factory(Task::class)->state($this->status->name)->create();
        $response = $this->delete(route('task_statuses.destroy', $this->status));
        $response->assertStatus(302);
        $this->assertEquals(4, TaskStatus::count());
    }
}
