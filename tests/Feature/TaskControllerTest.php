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

    public const TYPE_GLOBAL_UPDATE = 'globalUpdate';
    public const TYPE_UPDATE_GET_TASK = 'getTask';
    public const TYPE_UPDATE_ABANDON_TASK = 'abandonTask';
    public const NEW_TASK_STATUS = 'new task';
    public const WORKING_TASK_STATUS = 'working';
    
    public function setUp(): void
    {
        parent::setUp();

        factory(User::class)->create();
        $this->task1 = factory(Task::class)->state(self::NEW_TASK_STATUS)->create();
        $this->task2 = factory(Task::class)->state(self::WORKING_TASK_STATUS)->create();
        $this->user = User::first();
        $this->actingAs($this->user);
    }
    
    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200)
            ->assertSee(Task::first()->name);
    }

    public function testIndexWithFilter()
    {
        $data = ['status' => $this->task1->status->id];
        $response = $this->get(route('tasks.index', $data));
        $response->assertStatus(200)
            ->assertSee($this->task1->name)
            ->assertDontSee($this->task2->name);
    }

    public function testStore()
    {
        $data = ['name' => factory(Task::class)->make()->name];
        $response = $this->post(route('tasks.store', $data));
        $response->assertStatus(302);
        $this->assertEquals(3, Task::count());
    }

    public function testUpdate()
    {
        $modelTaskForUpdate = factory(Task::class)->state(self::NEW_TASK_STATUS)->make();
        $dataForUpdate = $modelTaskForUpdate->toArray();
        $dataForUpdate['type'] = self::TYPE_GLOBAL_UPDATE;

        $response = $this->patch(route('tasks.update', $this->task1), $dataForUpdate);

        $this->task1->refresh();
        $this->assertEquals($this->task1->description, $dataForUpdate['description']);
    }

    public function testUpdateGetTask()
    {
        $data = ['type' => self::TYPE_UPDATE_GET_TASK];
        $this->patch(route('tasks.update', $this->task1), $data);
        $this->task1->refresh();
        $this->assertEquals($this->user, $this->task1->executor);
    }

    public function testUpdateAbandonTask()
    {
        $this->task1->executor()->associate($this->user);
        $this->task1->save();
        $data = ['type' => self::TYPE_UPDATE_ABANDON_TASK];
        $this->patch(route('tasks.update', $this->task1), $data);
        $this->task1->refresh();
        $this->assertNotEquals($this->user, $this->task1->executor);
    }

    public function testView()
    {
        $response = $this->get(route('tasks.show', $this->task1));
        $response->assertStatus(200)
            ->assertSee($this->task1->name);
    }
}
