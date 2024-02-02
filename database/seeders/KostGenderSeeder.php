<?php

namespace Database\Seeders;

use App\Models\KostGender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KostGenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kostGender1 = new KostGender();
        $kostGender1->id = 1;
        $kostGender1->gender_type = 'KHUSUS WANITA';
        $kostGender1->save();

        $kostGender2 = new KostGender();
        $kostGender2->id =2;
        $kostGender2->gender_type = 'KHUSUS PRIA';
        $kostGender2->save();

        $kostGender3 = new KostGender();
        $kostGender3->id = 3;
        $kostGender3->gender_type = 'CAMPUR';
        $kostGender3->save();
    }
}
