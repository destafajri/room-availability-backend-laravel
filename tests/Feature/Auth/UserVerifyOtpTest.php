<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class UserVerifyOtpTest extends TestCase
{
    public function test_UserSuccessVerifyOtp(): void
    {
        // setup
        $user = User::withTrashed()->where('email', 'tenant_regular_tester_seeder@gmail.com')->first();

        $otp = "123456";
        $key = "OTP-email_" . $user->email;
        $expTime = 300;
        Redis::setex($key, $expTime, $otp);

        // action
        $response = $this->post('/api/otp/verify', [
            'email' => 'tenant_regular_tester_seeder@gmail.com',
            'otp' => '123456'
        ]);

        // assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User success verify otp'
            ]);

        $user = User::where('email', $user->email)->first();
        self::assertNotNull(
            $user->email_verified_at
        );
        self::assertNotNull(
            $user->remember_token
        );
    }

    public function test_UserNotFoundVerifyOtp(): void
    {
        // setup
        $user = User::withTrashed()->where('email', 'tenant_regular_tester_seeder@gmail.com')->first();

        $otp = "123456";
        $key = "OTP-email_" . $user->email;
        $expTime = 300;
        Redis::setex($key, $expTime, $otp);

        // action
        $response = $this->post('/api/otp/verify', [
            'email' => 'tenant_regular_tester_seeder_not_found@gmail.com',
            'otp' => '123456'
        ]);

        // assert
        $response->assertStatus(400)
            ->assertJson([
                'error' => [
                    'User not found'
                ]
            ]);

        $user = User::where('email', $user->email)->first();
        self::assertNull(
            $user->remember_token
        );
    }

    public function test_UserInputInvalidOtp(): void
    {
        // setup
        $user = User::withTrashed()->where('email', 'owner_tester_seeder@gmail.com')->first();

        $otp = "123456";
        $key = "OTP-email_" . $user->email;
        $expTime = 300;
        Redis::setex($key, $expTime, $otp);

        // action
        $response = $this->post('/api/otp/verify', [
            'email' => 'owner_tester_seeder@gmail.com',
            'otp' => '123458'
        ]);

        // assert
        $response->assertStatus(400)
            ->assertJson([
                'error' => [
                    "OTP doesn't valid"
                ]
            ]);

        $user = User::where('email', $user->email)->first();
        self::assertNotNull(
            $user->email_verified_at
        );
        self::assertNull(
            $user->remember_token
        );
    }
}
