<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdditionalAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $area = new Area();
        $area->id = 7;
        $area->area_name = 'Jakarta Selatan';
        $area->save();

        $area = new Area();
        $area->id = 8;
        $area->area_name = 'Jakarta Utara';
        $area->save();

        $area = new Area();
        $area->id = 9;
        $area->area_name = 'Jakarta Barat';
        $area->save();
        
        $area = new Area();
        $area->id = 10;
        $area->area_name = 'Jakarta Pusat';
        $area->save();

        $area = new Area();
        $area->id = 11;
        $area->area_name = 'Bandung Selatan';
        $area->save();

        $area = new Area();
        $area->id = 12;
        $area->area_name = 'Jogja Utara';
        $area->save();

        $area = new Area();
        $area->id = 13;
        $area->area_name = 'Semarang Barat';
        $area->save();

        $area = new Area();
        $area->id = 14;
        $area->area_name = 'Surabaya Timur';
        $area->save();

        $area = new Area();
        $area->id = 15;
        $area->area_name = 'Bali Selatan';
        $area->save();

        $area = new Area();
        $area->id = 16;
        $area->area_name = 'Bali Utaran';
        $area->save();
    }
}
