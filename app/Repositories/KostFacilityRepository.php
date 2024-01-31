<?php

namespace App\Repositories;

use App\Models\Kost;

interface KostFacilityRepository
{
    public function attachKostFacilities(Kost $kost, array $facilities): void;
}