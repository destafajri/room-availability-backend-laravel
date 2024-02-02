<?php

namespace App\Repositories\Impl;

use App\Models\Kost;
use App\Models\Owner;
use App\Repositories\KostRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class KostRepositoryImpl implements KostRepository
{
    public function saveNewKost(Kost $kost): void
    {
        $kost->saveOrFail();
    }

    public function updateKost(Kost $kost): void
    {
        $kost->save();
    }

    public function deleteKost(Kost $kost): void
    {
        $kost->deleteOrFail();
    }

    public function findListKostByOwner(Request $request, Owner $owner): LengthAwarePaginator
    {
        $perPage = $request->query('per_page', 15); // Default to 15 per page
        $page = $request->query('page', 1); // Default to page 1
        $sortBy = $request->query('sortby', 'created_at'); // Default to sorting by created_at
        $sortOrder = $request->query('sort_order', 'desc'); // Default to desc order

        return Kost::withoutGlobalScope(\App\Models\Scopes\IsActiveScope::class)
            ->with(['owner', 'kostGender', 'area', 'facilities'])
            ->orderBy($sortBy, $sortOrder)
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function findAllKostListings(Request $request): LengthAwarePaginator
    {
        $perPage = $request->query('per_page', 15); // Default to 15 per page
        $page = $request->query('page', 1); // Default to page 1
        $sortBy = $request->query('sortby', 'created_at'); // Default to sorting by created_at
        $sortOrder = $request->query('sort_order', 'desc'); // Default to desc order

        return Kost::with(['owner', 'kostGender', 'area', 'facilities'])
            ->orderBy($sortBy, $sortOrder)
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function findKostListingsByIds(Request $request): LengthAwarePaginator
    {
        $perPage = $request->query('per_page', 15); // Default to 15 per page
        $page = $request->query('page', 1); // Default to page 1
        $sortBy = $request->query('sortby', 'created_at'); // Default to sorting by created_at
        $sortOrder = $request->query('sort_order', 'desc'); // Default to desc order

        return Kost::with(['owner', 'kostGender', 'area', 'facilities'])
            ->whereIn('id', $request->id)
            ->orderBy($sortBy, $sortOrder)
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function findKostDetailById(int $id): Kost
    {
        return Kost::with('owner', 'kostGender', 'area', 'facilities')
            ->findOrFail($id);
    }

    public function searchKostWithMatchingKostName(string $searchKey): Collection
    {
        return Kost::whereFullText('kost_name', "%$searchKey%")
            ->orderBy('price', 'desc')
            ->limit(10)
            ->get();
    }

    public function searchKostInPriceRange(int $lowerPrice, int $upperPrice): Collection
    {
        return Kost::whereBetween('price', [$lowerPrice, $upperPrice])
            ->orderBy('price', 'desc')
            ->limit(10)
            ->get();
    }
}