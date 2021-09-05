<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
    */
    public function a_user_can_create_a_token()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->json('POST', '/api/token', [
            'email' => $user['email'],
            'password' => 'password',
            'device_name' => 'test_device'
        ]);

        $response->assertStatus(201);
    }

        /**
     * @test
     * @return void
    */
    public function a_user_can_destroy_their_token()
    {
        $user = User::factory()->create();

        $token = $this->actingAs($user)->json('POST', '/api/token', [
            'email' => $user['email'],
            'password' => 'password',
            'device_name' => 'test_device'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token['token'],
            'Accept' => 'application/json'
            ])->json('POST', '/api/token/revoke', [
            'id' => $token['id']
        ]);

        $response->assertStatus(204);
    }
}
