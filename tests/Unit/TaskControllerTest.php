<?php

namespace Tests\Unit;

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
        $date = Task::find(1)->toArray();
        $date['status_id'] = 4;
        $response = $this->actingAs(User::first())
            ->patch(route('tasks.update', Task::find(1)), $date);
        $this->assertEquals(4, Task::find(1)->status->id);
    }

    public function testView()
    {
        $response = $this->get(route('tasks.show', Task::find(1)));
        $response->assertStatus(200);
        $response->assertSee(Task::find(1)->name);
    }

    public function testGetTask()
    {
        $this->assertNotEquals(1, Task::find(1)->assignedTo_id);
        $this->actingAs(User::first())
            ->patch(route('tasks.get_task', Task::find(1)));
        $this->assertEquals(1, Task::find(1)->assignedTo_id);
    }

    public function testDenyTask()
    {
        $task =Task::find(1);
        $task->assignedTo_id = 1;
        $task->save();
        $this->assertEquals(1, Task::find(1)->assignedTo_id);
        $this->actingAs(User::first())
            ->patch(route('tasks.deny_task', Task::find(1)));
        $this->assertNotEquals(1, Task::find(1)->assignedTo_id);
    }
}
