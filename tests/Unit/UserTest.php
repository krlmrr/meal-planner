<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /**
     * A test to see if a user can see their own info.
     *
     * @return void
     */
    public function test_user_can_see_their_info()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json('GET', '/api/user');

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ]);
    }
}
