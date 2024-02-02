<?php

namespace App\Repositories\Impl;

use App\Models\Area;
use App\Models\Kost;
use App\Repositories\AreaRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AreaRepositoryImpl implements AreaRepository
{
    public function searchAreasWithMatchingAreaName(string $searchKey): Collection
    {
        return Area::whereFullText('area_name', "$searchKey")
            ->with([
                'kosts' => function ($query) {
                    $query->orderBy('price', 'desc');
                }
            ])
            ->limit(10)
            ->get();
    }
}