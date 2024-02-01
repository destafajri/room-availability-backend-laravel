<?php

namespace Database\Seeders;

use App\Models\Kost;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KostTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('phone_number', '08119787884')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing 1";
        $kost->owner_id = $user->owner->id;
        $kost->description = "okeoekoeoe";
        $kost->address = "mamamamam";
        $kost->price = 5000000;
        $kost->room_total = 10;
        $kost->room_available = 0;
        $kost->kost_gender_id = 3;
        $kost->area_id = 1;
        $kost->save();

        $user = User::where('phone_number', '08119787884')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing 2";
        $kost->owner_id = $user->owner->id;
        $kost->description = "okeoekoeoe";
        $kost->address = "mamamamam";
        $kost->price = 5000000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 1;
        $kost->save();
    }
}
