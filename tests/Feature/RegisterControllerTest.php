<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $faker = \Faker\Factory::create();
        $password = $faker->password(8);
        $this->dataNewUser = [
            'name' => $faker->unique()->name,
            'email' => $faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
            'firstname' => $faker->name,
            'lastname' => $faker->name,
            'sex' => $faker->randomElement(['male', 'female']),
            'birth_day' => $faker->numberBetween($min = 1, $max = 31),
            'birth_month' => $faker->numberBetween($min = 1, $max = 12),
            'birth_year' => $faker->numberBetween($min = 1930, $max = 2015),
            'country' => $faker->country,
            'city' => $faker->city
        ];

        $this->expectData = array_filter($this->dataNewUser, function ($key) {
            $keyForDelete = ['password', 'password_confirmation'];
            return !in_array($key, $keyForDelete);
        }, ARRAY_FILTER_USE_KEY);
    }
    
    public function testCreateUser()
    {
        $response = $this->post('/register', $this->dataNewUser);

        $response->assertStatus(302);
        $this->assertEquals(1, User::count());

        $user = User::first();
        $userData = array_filter($user->toArray(), function ($key) {
            $keyForDelete = [
                'email_verified_at',
                'created_at',
                'updated_at',
                'password',
                'deleted_at',
                'id'
            ];
            return !in_array($key, $keyForDelete);
        }, ARRAY_FILTER_USE_KEY);
        $this->assertEquals($this->expectData, $userData);
    }
}
