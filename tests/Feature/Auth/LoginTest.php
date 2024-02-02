<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_LoginOwnerSuccess(): void
    {
        // act
        $response = $this->post('/api/login', [
            'phone_number' => '08119787884',
            'password' => '123456'
        ]);

        // assertion
        $response->assertStatus(200)->assertJson([
            'message' => 'Login Success'
        ]);
    }

    public function test_LoginTenantPremiumSuccess(): void
    {
        // act
        $response = $this->post('/api/login', [
            'phone_number' => '081197878841',
            'password' => '123456'
        ]);

        // assertion
        $response->assertStatus(200)->assertJson([
            'message' => 'Login Success'
        ]);
    }

    public function test_LoginTenantRegullarSuccess(): void
    {
        // act
        $response = $this->post('/api/login', [
            'phone_number' => '081197878842',
            'password' => '123456'
        ]);

        // assertion
        $response->assertStatus(200)->assertJson([
            'message' => 'Login Success'
        ]);
    }

    public function test_LoginUserUnregisterd(): void
    {
        // act
        $response = $this->post('/api/login', [
            'phone_number' => '0811978788',
            'password' => '123456'
        ]);

        // assertion
        $response->assertStatus(400)->assertJson([
            'error' => [
                'User not found'
            ]
        ]);
    }

    public function test_LoginInvalidInput(): void
    {
        // act
        $response = $this->post('/api/login', [
            'phone_number' => '08119787-88',
            'password' => '123456'
        ]);

        // assertion
        $response->assertStatus(422)->assertJson([
            'error' => [
                'phone_number' => [
                    'The phone number field format is invalid.'
                ]
            ]
        ]);
    }

    public function test_LoginUserUnverifyEmail(): void
    {
        // setup
        $user = User::withTrashed()->where('email', 'tenant_regular_tester_seeder@gmail.com')->first();
        $user->email_verified_at = null;
        $user->save();

        // act
        $response = $this->post('/api/login', [
            'phone_number' => '081197878842',
            'password' => '123456'
        ]);

        // assertion
        $response->assertStatus(401)->assertJson([
            'error' => [
                "User hasn't verified email"
            ]
        ]);
    }

    public function test_LoginUserIsWaitingForDelete(): void
    {
        // setup
        $user = User::withTrashed()->where('email', 'tenant_regular_tester_seeder@gmail.com')->first();
        $user->delete();

        // act
        $response = $this->post('/api/login', [
            'phone_number' => '081197878842',
            'password' => '123456'
        ]);

        // assertion
        $response->assertStatus(400)->assertJson([
            'error' => [
                "User not found"
            ]
        ]);
    }
}
