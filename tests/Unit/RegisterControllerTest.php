<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'name' => 'Escudo',
            'email' => '123@re.ru',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'firstname' => 'test',
            'lastname' => 'test',
            'sex' => 'male',
            'birth_day' => 1,
            'birth_month' => 6,
            'birth_year' => 1986,
            'country' => 'kurkudu',
            'city' => 'city'
        ];

        $this->expectData = [
            'name' => 'Escudo',
            'email' => '123@re.ru',
            'firstname' => 'test',
            'lastname' => 'test',
            'sex' => 'male',
            'birth_day' => 1,
            'birth_month' => 6,
            'birth_year' => 1986,
            'country' => 'kurkudu',
            'city' => 'city'
        ];
    }
    
    public function testCreateUser()
    {
        $response = $this->post('/register', $this->data);
        $response->assertStatus(302);
        $this->assertEquals(1, \App\User::count());
        $this->assertDatabaseHas('users', $this->expectData);
    }
}
