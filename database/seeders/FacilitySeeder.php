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
        $pool->facility_name = "Pool";
        $pool->save();

        $sauna = new Facility();
        $sauna->facility_name = "Sauna";
        $sauna->save();

        $gym = new Facility();
        $gym->facility_name = "Gym";
        $gym->save();

        $resto = new Facility();
        $resto->facility_name = "Resto";
        $resto->save();

        $kamarMandiRebahan = new Facility();
        $kamarMandiRebahan->facility_name = "Kamar Mandi Rebahan";
        $kamarMandiRebahan->save();
    }
}
