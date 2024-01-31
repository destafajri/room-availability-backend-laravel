<?php

namespace App\Repositories\Impl;

use App\Models\Kost;
use App\Repositories\KostRepository;
use Illuminate\Support\Facades\DB;

class KostRepositoryImpl implements KostRepository
{
    public function saveNewKost(Kost $kost): void
    {
        $kost->save();
    }
}