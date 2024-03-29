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

        // owner 2
        $user = new User();
        $owner2 = new Owner();
        $user->name = 'owner tester feature 2';
        $user->phone_number = '08119787881';
        $user->email = 'owner_tester_seeder2@gmail.com';
        $user->role_id = 1;
        $user->password = Hash::make('123456');
        $user->email_verified_at = Carbon::now();
        $user->save();

        $user = User::withTrashed()->where('email', $user->email)->first();
        $owner2->user_id = $user->id;
        $owner2->save();

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

        // tenant regular
        $user = new User();
        $tenantRegular = new Tenant();
        $user->name = 'tenant regular tester feature';
        $user->phone_number = '081197878842';
        $user->email = 'tenant_regular_tester_seeder@gmail.com';
        $user->role_id = 2;
        $user->password = Hash::make('123456');
        $user->email_verified_at = Carbon::now();
        $user->save();

        $user = User::withTrashed()->where('email', $user->email)->first();
        $tenantRegular->user_id = $user->id;
        $tenantRegular->is_prime = false;
        $tenantRegular->credit = 20;
        $tenantRegular->save();

        // tenant regular doesnt has credit
        $user = new User();
        $tenantRegular = new Tenant();
        $user->name = 'tenant regular tester feature';
        $user->phone_number = '081197878843';
        $user->email = 'tenant_regular_tester_seeder2@gmail.com';
        $user->role_id = 2;
        $user->password = Hash::make('123456');
        $user->email_verified_at = Carbon::now();
        $user->save();

        $user = User::withTrashed()->where('email', $user->email)->first();
        $tenantRegular->user_id = $user->id;
        $tenantRegular->is_prime = false;
        $tenantRegular->credit = 1;
        $tenantRegular->save();
    }
}
