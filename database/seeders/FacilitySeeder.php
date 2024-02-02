<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pool = new Facility();
        $pool->id = 1;
        $pool->facility_name = "Pool";
        $pool->save();

        $sauna = new Facility();
        $sauna->id = 2;
        $sauna->facility_name = "Sauna";
        $sauna->save();

        $gym = new Facility();
        $gym->id = 3;
        $gym->facility_name = "Gym";
        $gym->save();

        $resto = new Facility();
        $resto->id = 4;
        $resto->facility_name = "Resto";
        $resto->save();

        $kamarMandiRebahan = new Facility();
        $kamarMandiRebahan->id = 5;
        $kamarMandiRebahan->facility_name = "Kamar Mandi Rebahan";
        $kamarMandiRebahan->save();
    }
}
