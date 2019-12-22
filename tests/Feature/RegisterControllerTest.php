<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->newUser = factory(User::class)->make();
        $this->dataNewUser = $this->newUser->toArray();
        $this->dataNewUser['password'] = \Faker\Factory::create()->password(8);
        $this->dataNewUser['password_confirmation'] = $this->dataNewUser['password'];
    }
    
    public function testCreateUser()
    {
        $this->assertEquals(0, User::count());
        
        $response = $this->post('/register', $this->dataNewUser);

        $response->assertStatus(302);
        $this->assertEquals(1, User::count());

        $createdUser = User::first();
        $this->assertEquals($this->newUser->name, $createdUser->name);
        $this->assertEquals($this->newUser->firstname, $createdUser->firstname);
    }
}
