<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;
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
    }
    
    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
        $response->assertSee(Task::first()->name);
    }

    public function testIndexWithFilter()
    {
        $taskName1 = Task::find(1)->name;
        $taskName2 = Task::find(2)->name;
        $response = $this->get(route('tasks.index', ['status' => 2]));
        $response->assertStatus(200);
        $response->assertSee($taskName2);
        $response->assertDontSee($taskName1);
    }

    public function testStore()
    {
        $response = $this->actingAs(User::first())
            ->post(route('tasks.store', ['name' => 'task']));
        $response->assertStatus(302);
        $this->assertEquals(3, Task::count());
    }

    public function testStoreWithoutAuthentication()
    {
        $response = $this->post(route('tasks.store', ['name' => 'task']));
        $response->assertStatus(302);
        $this->assertEquals(2, Task::count());
    }

    public function testUpdate()
    {
        $data = Task::find(1)->toArray();
        $data['status_id'] = 4;
        $data['type'] = 'globalUpdate';
        $response = $this->actingAs(User::first())
            ->patch(route('tasks.update', Task::find(1)), $data);
        $this->assertEquals(4, Task::find(1)->status->id);
    }

    public function testUpdateGetTask()
    {
        $this->assertNotEquals(1, Task::find(1)->assignedTo_id);
        $data = ['type' => 'getTask'];
        $this->actingAs(User::find(1))
            ->patch(route('tasks.update', Task::find(1)), $data);
        $this->assertEquals(1, Task::find(1)->assignedTo_id);
    }

    public function testUpdateAbandonTask()
    {
        $task = Task::find(1);
        $task->assignedTo_id = 1;
        $task->save();
        $this->assertEquals(1, Task::find(1)->assignedTo_id);
        $data = ['type' => 'abandonTask'];
        $this->actingAs(User::find(1))
            ->patch(route('tasks.update', Task::find(1)), $data);
        $this->assertNotEquals(1, Task::find(1)->assignedTo_id);
    }

    public function testView()
    {
        $response = $this->get(route('tasks.show', Task::find(1)));
        $response->assertStatus(200);
        $response->assertSee(Task::find(1)->name);
    }
}
