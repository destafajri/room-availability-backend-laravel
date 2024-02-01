<?php

namespace App\Repositories\Impl;

use App\Models\Area;
use App\Repositories\AreaRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AreaRepositoryImpl implements AreaRepository
{
    public function searchAreasWithMatchingAreaName(string $searchKey): Collection
    {
        return Area::with('kosts')->where('area_name', 'like', "%$searchKey%")->get();
    }
}