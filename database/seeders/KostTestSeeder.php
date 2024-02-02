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
        $kost->description = "kost feature testing gang 1000 description";
        $kost->address = "kost feature testing gang 1000 ahok";
        $kost->price = 5000000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 10;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing owner 2";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description";
        $kost->address = "kost feature testing gang 1000";
        $kost->price = 5000000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 11;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing owner 2 jokowi";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description";
        $kost->address = "kost feature testing gang 1000 jokowi";
        $kost->price = 5000000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 12;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description banteng";
        $kost->address = "kost feature testing gang 1000 banteng";
        $kost->price = 5000000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 2;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing owner gerindra";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description";
        $kost->address = "kost feature testing gang 1000";
        $kost->price = 5000000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 11;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing owner 2 prabowo";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description";
        $kost->address = "kost feature testing gang 1000 prabowo";
        $kost->price = 5000000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 12;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas pks";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description pks";
        $kost->address = "kost feature testing gang 1000 pks";
        $kost->price = 5000000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 7;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas psi";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description psi";
        $kost->address = "kost feature testing gang 1000 psi";
        $kost->price = 5000000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 3;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng syariah";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description banteng syariah";
        $kost->address = "kost feature testing gang 1000 syariah";
        $kost->price = 5000000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 4;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng syariah 5";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description banteng syariah 5";
        $kost->address = "kost feature testing gang 1000 syariah ";
        $kost->price = 5100000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 5;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng syariah 6";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description banteng syariah 6";
        $kost->address = "kost feature testing gang 1000 syariah ";
        $kost->price = 5200000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 6;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng syariah 7";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description banteng syariah 7";
        $kost->address = "kost feature testing gang 1000 syariah ";
        $kost->price = 4900000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 7;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng syariah 8";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description banteng syariah 8";
        $kost->address = "kost feature testing gang 1000 syariah ";
        $kost->price = 4800000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 8;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng syariah 9";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description banteng syariah 9";
        $kost->address = "kost feature testing gang 1000 syariah ";
        $kost->price = 4700000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 9;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng syariah 10";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000 description banteng syariah 10";
        $kost->address = "kost feature testing gang 1000 syariah ";
        $kost->price = 46000000;
        $kost->room_total = 10;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 10;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng syariah 11";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1100 description banteng syariah 11";
        $kost->address = "kost feature testing gang 1100 syariah ";
        $kost->price = 4400000;
        $kost->room_total = 11;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 11;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng syariah 12";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1200 description banteng syariah 12";
        $kost->address = "kost feature testing gang 1200 syariah ";
        $kost->price = 4950000;
        $kost->room_total = 12;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 12;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng syariah 13";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1300 description banteng syariah 13";
        $kost->address = "kost feature testing gang 1300 syariah ";
        $kost->price = 4850000;
        $kost->room_total = 13;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 13;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng syariah 14";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1400 description banteng syariah 14";
        $kost->address = "kost feature testing gang 1400 syariah ";
        $kost->price = 4730000;
        $kost->room_total = 14;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 14;
        $kost->save();

        $user = User::where('phone_number', '08119787881')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing markas banteng syariah 15";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1500 description banteng syariah 15";
        $kost->address = "kost feature testing gang 1500 syariah ";
        $kost->price = 4770000;
        $kost->room_total = 15;
        $kost->room_available = 2;
        $kost->kost_gender_id = 3;
        $kost->area_id = 15;
        $kost->save();

        $user = User::where('phone_number', '08119787884')->first();
        $kost = new Kost();
        $kost->kost_name = "kost feature testing 2";
        $kost->owner_id = $user->owner->id;
        $kost->description = "kost feature testing gang 1000";
        $kost->address = "kost Jakarta feature testing gang 1000";
        $kost->price = 5000000;
        $kost->room_total = 10;
        $kost->room_available = 0;
        $kost->kost_gender_id = 3;
        $kost->area_id = 2;
        $kost->save();
    }
}
