<?php

namespace Tests\Feature;

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
        $this->user = User::first();
    }
    
    public function testIndex()
    {
        $route = route('task_statuses.index');
        $response = $this->actingAs($this->user)->get($route);

        $response->assertStatus(200);

        $status = TaskStatus::first();
        $response->assertSee($status->name);
    }

    public function testStore()
    {
        $newStatusName = 'new status test';
        $date = ['name' => $newStatusName];

        $route = route('task_statuses.store');
        $response = $this->actingAs($this->user)->post($route, $date);

        $response->assertStatus(302);
        $this->assertEquals(5, TaskStatus::count());

        $statusWithNewNameCount = TaskStatus::where('name', $newStatusName)->count();
        $this->assertEquals(1, $statusWithNewNameCount);
    }

    public function testUpdate()
    {
        $status = TaskStatus::first();
        $newStatusName = 'new status test';
        $data = $status->toArray();
        $updatedData = array_replace($data, ['name' => $newStatusName]);

        $route = route('task_statuses.update', $status);
        $response = $this->actingAs($this->user)->patch($route, $updatedData);

        $response->assertStatus(302);

        $updatedStatus = TaskStatus::find($status->id);
        $this->assertEquals($newStatusName, $updatedStatus->name);
    }

    public function testDestroy()
    {
        $status = TaskStatus::first();
        $route = route('task_statuses.destroy', $status);
        $response = $this->actingAs($this->user)->delete($route);

        $response->assertStatus(302);
        $this->assertEquals(3, TaskStatus::count());
    }

    public function testDestroyWithDate()
    {
        $statusName = 'testing';
        $status = TaskStatus::where('name', $statusName)->first();
        factory(Task::class)->state($statusName)->create();
        
        $route = route('task_statuses.destroy', $status);
        $response = $this->actingAs($this->user)->delete($route);

        $response->assertStatus(302);
        $this->assertEquals(4, TaskStatus::count());
    }
}
