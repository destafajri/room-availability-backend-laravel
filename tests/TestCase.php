<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Database\Seeders\UserTestSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::withTrashed()->where('email', 'test@gmail.com')->first() ?:
            User::withTrashed()->where('phone_number', '085325378350')->first();

        // Check if the user exists
        if ($user) {
            // If the user exists, delete related records
            DB::delete("DELETE FROM tenants where user_id = ?", [$user->id]);
            DB::delete("DELETE FROM owners where user_id = ?", [$user->id]);
            DB::delete("DELETE FROM users where id = ?", [$user->id]);
        }

        // delete user from seeder
        $owner = User::withTrashed()->where('email', 'owner_tester_seeder@gmail.com')->first();
        if ($owner) {
            DB::delete("DELETE FROM owners where user_id = ?", [$owner->id]);
            DB::delete("DELETE FROM users where id = ?", [$owner->id]);
        }

        $this->seed(UserTestSeeder::class);
    }
}
