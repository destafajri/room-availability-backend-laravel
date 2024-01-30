<?php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // owner
        $user = new User();
        $owner = new Owner();
        $user->name = 'owner tester feature';
        $user->phone_number = '08119787884';
        $user->email = 'owner_tester_seeder@gmail.com';
        $user->role_id = 1;
        $user->password = Hash::make('123456');
        $user->email_verified_at = Carbon::now();
        $user->save();

        $user = User::withTrashed()->where('email', $user->email)->first();
        $owner->user_id = $user->id;
        $owner->save();

        // tenant prime
        $user = new User();
        $tenantPrime = new Tenant();
        $user->name = 'tenant prime tester feature';
        $user->phone_number = '081197878841';
        $user->email = 'tenant_prime_tester_seeder@gmail.com';
        $user->role_id = 2;
        $user->password = Hash::make('123456');
        $user->email_verified_at = Carbon::now();
        $user->save();

        $user = User::withTrashed()->where('email', $user->email)->first();
        $tenantPrime->user_id = $user->id;
        $tenantPrime->is_prime = true;
        $tenantPrime->credit = 40;
        $tenantPrime->save();
    }
}
