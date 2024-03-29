<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserTestSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(FacilitySeeder::class);
        $this->call(KostGenderSeeder::class);
        $this->call(AdditionalAreaSeeder::class);
    }
}
