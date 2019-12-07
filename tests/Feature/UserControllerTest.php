<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        
        factory(\App\User::class)->create();
        $this->user = \App\User::first();

        $faker = \Faker\Factory::create();
        $this->updatedData = array_replace($this->user->toArray(), [
            'firstname' => $faker->name,
            'lastname' => $faker->name,
            'birth_day' => $faker->numberBetween($min = 1, $max = 31),
            'birth_month' => $faker->numberBetween($min = 1, $max = 12),
            'birth_year' => $faker->numberBetween($min = 1930, $max = 2015),
            'country' => $faker->country,
            'city' => $faker->city
        ]);
        $this->invalidData = array_replace($this->updatedData, [
            'birth_year' => $faker->numberBetween($min = 0, $max = 1000),
        ]);
    }
    
    public function testUpdate()
    {
        $this->assertEquals(1, \App\User::count());
        $data = array_replace($this->updatedData, ['type' => 'updateProfile']);
        $response = $this->actingAs($this->user)
            ->patch(route('users.update', $this->user), $data);
        $response->assertStatus(302);
        $this->assertEquals(1, \App\User::count());
        $this->assertDatabaseHas('users', $this->updatedData);
    }

    public function testUpdateWithInvalidData()
    {
        $data = array_replace($this->invalidData, ['type' => 'updateProfile']);
        $response = $this->actingAs($this->user)
            ->patch(route('users.update', $this->user), $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', $this->user->toArray());
    }

    public function testIndex()
    {
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertSee($this->user->name);
    }

    public function testView()
    {
        $response = $this->get(route('users.show', $this->user));
        $response->assertStatus(200);
        $response->assertSee($this->user->name);
    }

    public function testDestroy()
    {
        $response = $this->actingAs($this->user)
            ->delete(route('users.destroy', $this->user));
        $response->assertStatus(302);
        $this->assertEquals(0, \App\User::count());
    }
}
