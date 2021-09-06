<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {
        $response = $this->json('POST', '/api/register', [
            'name' => 'Test User',
            'email' => 'test_user@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(201);
    }


    /** @test */
    public function a_user_can_log_in()
    {
        $user = User::factory()->create();

        $response = $this->json('POST', '/api/login', [
            'email' => $user['email'],
            'password' => 'password'
        ]);

        $response->assertStatus(204);
    }

    /** @test */
    public function user_can_see_their_info()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->json('GET', '/api/user');

        $response->assertStatus(200);
        $response->assertJson([
            'name' => $user['name'],
            'email' => $user['email']
        ]);
    }  
}
