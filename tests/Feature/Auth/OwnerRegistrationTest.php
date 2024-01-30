<?php

namespace Tests\Feature\Auth;

use App\Models\Owner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class OwnerRegistrationTest extends TestCase
{
    public function test_OwnerRegistrationSuccess(): void
    {
        // act
        $response = $this->post('/api/register/owner', [
            'name' => 'owner test',
            'phone_number' => '085325378350',
            'email' => 'test@gmail.com',
            'password' => '12345689'
        ]);

        // assertion
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Success request owner register'
            ]);

        $user = User::withTrashed()->where('email', 'test@gmail.com')->first();
        self::assertNotNull(Owner::where('user_id', $user->id));
    }

    public function test_OwnerRegistrationInvalidInput(): void
    {
        // act
        $response = $this->post('/api/register/owner', [
            'name' => 'te',
            'phone_number' => 'email.com',
            'email' => 'testgmail.com',
            'password' => '123'
        ]);

        // assertion
        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name' => [
                        'The name field must be at least 3 characters.'
                    ],
                    'phone_number' => [
                        'The phone number field format is invalid.'
                    ],
                    'email' => [
                        'The email field must be a valid email address.',
                    ],
                    'password' => [
                        'The password field must be at least 6 characters.',
                    ],
                ]
            ]);
    }

    public function test_OwnerRegistrationWaitForDeletion(): void
    {
        //setup
        $user = User::withTrashed()->where('email', 'owner_tester_seeder@gmail.com')->first();
        $user->delete();

        // act
        $response = $this->post('/api/register/owner', [
            'name' => 'test',
            'phone_number' => '08532537835',
            'email' => 'owner_tester_seeder@gmail.com',
            'password' => '123456'
        ]);

        // assertion
        $response->assertStatus(400)
            ->assertJson([
                'error' => [
                    'Please wait 2 days after request delete'
                ]
            ]);
    }

    public function test_OwnerRegistrationUserAlreadyVerify(): void
    {
        //setup

        $user = User::withTrashed()->where('email', 'owner_tester_seeder@gmail.com')->first();
        $user->email_verified_at = Carbon::now();
        $user->save();

        // act
        $response = $this->post('/api/register/owner', [
            'name' => 'test',
            'phone_number' => '08532537835',
            'email' => 'owner_tester_seeder@gmail.com',
            'password' => '123456'
        ]);

        // assertion
        $response->assertStatus(400)
            ->assertJson([
                'error' => [
                    'User already registered'
                ]
            ]);

        $user = User::withTrashed()->where('email', 'owner_tester_seeder@gmail.com')->first();
        self::assertNotNull(Owner::where('user_id', $user->id));
    }

}
