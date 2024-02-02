<?php

namespace App\Repositories;

use App\Models\Area;
use Illuminate\Database\Eloquent\Collection;

interface AreaRepository
{
    public function searchAreasWithMatchingAreaName(string $searchKey): Collection;
}