<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;
use App\TaskStatus;
use App\User;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();

        factory(User::class)->create();

        factory(Task::class)->state('new task')->create();
        factory(Task::class)->state('working')->create();
        factory(Task::class)->state('testing')->create();
        factory(Task::class)->state('terminated')->create();

        $this->user = User::first();
    }
    
    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertSee(Task::first()->name);
    }

    public function testIndexWithFilter()
    {
        $taskStatus1 = TaskStatus::first();
        $taskStatus2 = TaskStatus::whereNotIn('id', [$taskStatus1->id])->first();

        $task1 = Task::where('status_id', $taskStatus1->id)->first();
        $task2 = Task::where('status_id', $taskStatus2->id)->first();

        $data = ['status' => $taskStatus1->id];

        $route = route('tasks.index', $data);
        $response = $this->get($route);

        $response->assertStatus(200);
        $response->assertSee($task1->name);
        $response->assertDontSee($task2->name);
    }

    public function testStore()
    {
        $taskName = \Faker\Factory::create()->text(20);
        $data = ['name' => $taskName];

        $route = route('tasks.store', $data);
        $response = $this->actingAs($this->user)->post($route);

        $response->assertStatus(302);
        $this->assertEquals(5, Task::count());
        $this->assertEquals(1, Task::where('name', $taskName)->count());
    }

    public function testStoreWithoutAuthentication()
    {
        $taskName = \Faker\Factory::create()->text(20);
        $data = ['name' => $taskName];

        $route = route('tasks.store', $data);
        $response = $this->post($route);

        $response->assertStatus(302);
        $this->assertEquals(4, Task::count());
        $this->assertEquals(0, Task::where('name', $taskName)->count());
    }

    public function testUpdate()
    {
        $task = Task::first();
        $status = TaskStatus::whereNotIn('id', [$task->status->id])->first();
        $executor = factory(User::class)->create();
        $newData = [
            'name' => \Faker\Factory::create()->text(20),
            'description' => \Faker\Factory::create()->text(30),
            'status_id' => $status->id,
            'assignedTo_id' => $executor->id
        ];

        $typeUpdate = 'globalUpdate';
        $dataForUpdate = array_merge($newData, ['type' => $typeUpdate]);

        $route = route('tasks.update', $task);
        $response = $this->actingAs($this->user)->patch($route, $dataForUpdate);

        $updatedTask = Task::find($task->id);
        $updatedData = [
            'name' => $updatedTask->name,
            'description' => $updatedTask->description,
            'status_id' => $updatedTask->status->id,
            'assignedTo_id' => $updatedTask->executor->id
        ];
        $this->assertEquals($newData, $updatedData);
    }

    public function testUpdateGetTask()
    {
        $task = Task::first();
        $this->assertNotEquals($this->user, $task->executor);

        $typeUpdate = 'getTask';
        $data = ['type' => $typeUpdate];

        $route = route('tasks.update', $task);
        $this->actingAs($this->user)->patch($route, $data);
        
        $updatedTask = Task::find($task->id);
        $this->assertEquals($this->user, $updatedTask->executor);
    }

    public function testUpdateAbandonTask()
    {
        $task = Task::first();
        $task->executor()->associate($this->user);
        $task->save();
        $this->assertEquals($this->user, $task->executor);

        $typeUpdate = 'abandonTask';
        $data = ['type' => $typeUpdate];

        $route = route('tasks.update', $task);
        $this->actingAs($this->user)->patch($route, $data);

        $updatedTask = Task::find($task->id);
        $this->assertNotEquals($this->user, $updatedTask->executor);
    }

    public function testView()
    {
        $task = Task::first();
        $response = $this->get(route('tasks.show', $task));

        $response->assertStatus(200);
        $response->assertSee($task->name);
    }
}
