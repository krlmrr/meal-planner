<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function a_user_can_create_a_token()
    {
        $response = $this->actingAs($this->user)->json('POST', '/api/token', [
            'email' => $this->user['email'],
            'password' => 'password',
            'device_name' => 'test_device'
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'message' => 'This is the last time you will see the token below in plain text, make sure you store it in a safe place.',
            'id' => $response['id'],
            'name' => $response['name'],
            'token' => $response['token'],
            'hashed_token' => $response['hashed_token']
        ]);
    }

    /** @test */
    public function a_user_can_destroy_their_token()
    {
        $token = $this->actingAs($this->user)->json('POST', '/api/token', [
            'email' => $this->user['email'],
            'password' => 'password',
            'device_name' => 'test_device'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token['token'],
            'Accept' => 'application/json'
        ])->json('POST', '/api/token/revoke', [
            'id' => $token['id']
        ]);

        $response->assertStatus(204);
    }

    /** @test */
    public function a_user_can_view_their_hashed_tokens()
    {
        $token1 = $this->actingAs($this->user)->json('POST', '/api/token', [
            'email' => $this->user['email'],
            'password' => 'password',
            'device_name' => 'test_device'
        ]);

        $token2 = $this->actingAs($this->user)->json('POST', '/api/token', [
            'email' => $this->user['email'],
            'password' => 'password',
            'device_name' => 'test_device_2'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token1['token'],
            'Accept' => 'application/json'
        ])->json('GET', '/api/tokens');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    /** @test */
    public function a_user_gets_unathenticated_if_they_dont_have_a_token()
    {
        $response = $this->actingAs($this->user)->json('GET', '/api/tokens');

        $response->assertJson([
            'message' => "No Tokens Found"
        ]);

        $response->assertStatus(200);
    }
}
