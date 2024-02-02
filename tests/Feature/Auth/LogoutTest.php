<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function test_logoutBearerTokenNull(): void
    {
        $response = $this->post('/api/logout');

        $response->assertStatus(401)
            ->assertJson([
                'error' => [
                    'Invalid token'
                ]
            ]);
    }
}
