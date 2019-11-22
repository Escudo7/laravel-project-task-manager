<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class userControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->data = array_merge($this->user->toArray(), [
            'firstname' => 'test',
            'lastname' => 'test',
            'birth_day' => 1,
            'birth_month' => 6,
            'birth_year' => 1986,
            'country' => 'kurkudu',
            'city' => 'city'
        ]);
        $this->invalidData = array_merge($this->user->toArray(), [
            'firstname' => 'test',
            'lastname' => 'test',
            'birth_day' => 1,
            'birth_month' => 6,
            'birth_year' => 1000,
            'country' => 'kurkudu',
            'city' => 'city'
        ]);
    }
    
    public function testUpdate()
    {
        $this->assertEquals(1, \App\User::count());
        $response = $this->patch(route('users.update', $this->user), $this->data);
        $response->assertStatus(302);
        $this->assertEquals(1, \App\User::count());
        $this->assertDatabaseHas('users', $this->data);
    }

    public function testUpdateWithInvalidData()
    {
        $response = $this->patch(route('users.update', $this->user), $this->invalidData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', $this->user->toArray());
    }

    public function testIndex()
    {
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
    }
}
