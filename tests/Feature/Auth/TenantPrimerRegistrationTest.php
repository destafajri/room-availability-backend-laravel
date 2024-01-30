<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantPrimerRegistrationTest extends TestCase
{
    public function test_TenantPrimeRegistrationSuccess(): void
    {
        // act
        $response = $this->post('/api/register/tenant/prime', [
            'name' => 'tenant test',
            'phone_number' => '085325378350',
            'email' => 'test@gmail.com',
            'password' => '12345689'
        ]);

        // assertion
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Success request tenant prime register'
            ]);

        $user = User::withTrashed()->where('email', 'test@gmail.com')->first();
        self::assertNotNull(Tenant::where('user_id', $user->id));
        self::assertEquals($user->role->role_name, 'TENANT');
        self::assertEquals($user->tenant->credit, 40);
        self::assertEquals($user->tenant->is_prime, true);
    }

    public function test_TenantPrimeRegistrationInvalidInput(): void
    {
        // act
        $response = $this->post('/api/register/tenant/prime', [
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

    public function test_TenantPrimeRegistrationWaitForDeletion(): void
    {
        //setup
        $user = User::withTrashed()->where('email', 'tenant_prime_tester_seeder@gmail.com')->first();
        $user->delete();

        // act
        $response = $this->post('/api/register/tenant/prime', [
            'name' => 'test',
            'phone_number' => '08532537835',
            'email' => 'tenant_prime_tester_seeder@gmail.com',
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

    public function test_TenantPrimeRegistrationUserAlreadyVerify(): void
    {
        //setup

        $user = User::withTrashed()->where('email', 'tenant_prime_tester_seeder@gmail.com')->first();
        $user->email_verified_at = Carbon::now();
        $user->save();

        // act
        $response = $this->post('/api/register/tenant/prime', [
            'name' => 'test',
            'phone_number' => '08532537835',
            'email' => 'tenant_prime_tester_seeder@gmail.com',
            'password' => '123456'
        ]);

        // assertion
        $response->assertStatus(400)
            ->assertJson([
                'error' => [
                    'User already registered'
                ]
            ]);

        $user = User::withTrashed()->where('email', 'tenant_prime_tester_seeder@gmail.com')->first();
        self::assertNotNull(Tenant::where('user_id', $user->id));
    }
}
