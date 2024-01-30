<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = new Role();
        $role1->role_name = 'OWNER';
        $role1->save();

        $role2 = new Role();
        $role2->role_name = 'TENANT';
        $role2->save();
    }
}
