<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        
        factory(User::class)->create();
        $this->user = User::first();

        $faker = \Faker\Factory::create();
        $this->data = array_replace($this->user->toArray(), [
            'firstname' => $faker->name,
            'lastname' => $faker->name,
            'birth_day' => $faker->numberBetween($min = 1, $max = 31),
            'birth_month' => $faker->numberBetween($min = 1, $max = 12),
            'birth_year' => $faker->numberBetween($min = 1930, $max = 2015),
            'country' => $faker->country,
            'city' => $faker->city
        ]);
        $this->invalidData = array_replace($this->data, [
            'birth_year' => $faker->numberBetween($min = 0, $max = 1000),
        ]);
    }
    
    public function testUpdate()
    {
        $typeUpdate = 'updateProfile';
        $dataToUpdate = array_merge($this->data, ['type' => $typeUpdate]);

        $route = route('users.update', $this->user);
        $response = $this->actingAs($this->user)->patch($route, $dataToUpdate);

        $response->assertStatus(302);
        $updatedUser = User::find($this->user->id);
        $this->assertEquals($this->data, $updatedUser->toArray());
    }

    public function testUpdateWithInvalidData()
    {
        $dataUserBeforUpdate = $this->user->toArray();
        
        $typeUpdate = 'updateProfile';
        $dataToUpdate = array_merge($this->invalidData, ['type' => $typeUpdate]);
        
        $route = route('users.update', $this->user);
        $response = $this->actingAs($this->user)->patch($route, $dataToUpdate);

        $response->assertStatus(302);

        $updatedUser = User::find($this->user->id);
        $this->assertNotEquals($this->invalidData, $updatedUser->toArray());
        $this->assertEquals($dataUserBeforUpdate, $updatedUser->toArray());
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
        $route = route('users.destroy', $this->user);
        $response = $this->actingAs($this->user)->delete($route);

        $response->assertStatus(302);
        $this->assertEquals(0, User::count());
    }
}
