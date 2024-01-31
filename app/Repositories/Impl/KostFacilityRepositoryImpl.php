<?php

namespace App\Repositories\Impl;

use App\Models\Kost;
use App\Repositories\KostFacilityRepository;
use Illuminate\Support\Facades\DB;

class KostFacilityRepositoryImpl implements KostFacilityRepository
{
    public function attachKostFacilities(Kost $kost, array $facilities): void
    {
        $kost->facilities()->attach($facilities);
    }

    public function detachAllKostFacilities(Kost $kost): void
    {
        $kost->facilities()->detach();
    }
}