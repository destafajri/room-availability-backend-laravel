<?php

namespace App\Repositories;

use App\Models\Kost;

interface KostRepository
{
    public function saveNewKost(Kost $kost): void;
}