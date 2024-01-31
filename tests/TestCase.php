<?php

namespace Tests;

use App\Models\FacilityKost;
use App\Models\Kost;
use App\Models\User;
use Database\Seeders\UserTestSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

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
        $userOwner = User::withTrashed()->where('email', 'owner_tester_seeder@gmail.com')->first();
        $userTenantPrime = User::withTrashed()->where('email', 'tenant_prime_tester_seeder@gmail.com')->first();
        $userTenantRegular = User::withTrashed()->where('email', 'tenant_regular_tester_seeder@gmail.com')->first();
        if ($userOwner) {
            $kostIds = Kost::where('owner_id', $userOwner->owner->id)->get('id');
            FacilityKost::whereIn('kost_id', $kostIds)->delete();
            Kost::where('owner_id', $userOwner->owner->id)->delete();
            $userOwner->owner->delete();
            $userOwner->forceDelete();
        }
        if ($userTenantPrime) {
            $userTenantPrime->tenant->delete();
            $userTenantPrime->forceDelete();
        }
        if ($userTenantRegular) {
            $userTenantRegular->tenant->delete();
            $userTenantRegular->forceDelete();
        }

        $this->seed(UserTestSeeder::class);
    }
}
