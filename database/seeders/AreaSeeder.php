<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $area1 = new Area();
        $area1->area_name = 'Jakarta';
        $area1->save();

        $area2 = new Area();
        $area2->area_name = 'Bandung';
        $area2->save();

        $area3 = new Area();
        $area3->area_name = 'Jogja';
        $area3->save();

        $area4 = new Area();
        $area4->area_name = 'Semarang';
        $area4->save();

        $area5 = new Area();
        $area5->area_name = 'Surabaya';
        $area5->save();

        $area6 = new Area();
        $area6->area_name = 'Bali';
        $area6->save();
    }
}
