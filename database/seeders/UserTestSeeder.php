<?php

namespace Database\Seeders;

use App\Models\Owner;
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
    }
}
