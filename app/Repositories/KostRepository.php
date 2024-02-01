<?php

namespace App\Repositories;

use App\Models\Kost;
use App\Models\Owner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface KostRepository
{
    public function saveNewKost(Kost $kost): void;
    public function updateKost(Kost $kost): void;
    public function deleteKost(Kost $kost): void;
    public function findListKostByOwner(Request $request, Owner $owner): LengthAwarePaginator;
    public function findAllKostListings(Request $request): LengthAwarePaginator;
    public function findKostListingsByIds(Request $request): LengthAwarePaginator;
    public function findKostDetailById(int $id): Kost;
    public function searchKostWithMatchingKostName(string $searchKey): Collection;
    public function searchKostInPriceRange(int $lowerPrice, int $upperPrice): Collection;
}