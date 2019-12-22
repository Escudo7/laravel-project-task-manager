<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    const TYPE_UPDATE = 'updateProfile';

    public function setUp(): void
    {
        parent::setUp();
        
        factory(User::class)->create();
        $this->user = User::first();
        $this->actingAs($this->user);
    }
    
    public function testUpdate()
    {
        $modelForUpdating = factory(User::class)->make();
        $dataToUpdate = $modelForUpdating->toArray();
        $dataToUpdate['type'] = self::TYPE_UPDATE;
        $response = $this->patch(route('users.update', $this->user), $dataToUpdate);

        $response->assertStatus(302);
        $this->user->refresh();
        $this->assertEquals($modelForUpdating->name, $this->user->name);
        $this->assertEquals($modelForUpdating->country, $this->user->country);
    }

    public function testIndex()
    {
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
    }

    public function testView()
    {
        $response = $this->get(route('users.show', $this->user));
        $response->assertStatus(200)
            ->assertSee($this->user->name);
    }

    public function testDestroy()
    {
        $response = $this->delete(route('users.destroy', $this->user));
        $response->assertStatus(302);
        $this->assertEquals(0, User::count());
    }
}
