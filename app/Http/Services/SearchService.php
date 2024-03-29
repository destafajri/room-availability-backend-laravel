<?php

namespace App\Http\Services;

use App\Http\Resources\Search\SearchResource;
use Illuminate\Http\Request;

interface SearchService
{
    public function searchSugesstionKost(Request $request): SearchResource;
}