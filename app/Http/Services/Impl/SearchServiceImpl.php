<?php

namespace App\Http\Services\Impl;

use App\Http\Resources\Kost\KostSimpleCollection;
use App\Http\Resources\Kost\KostSimpleResource;
use App\Http\Resources\Search\SearchResource;
use App\Http\Services\SearchService;
use App\Repositories\AreaRepository;
use App\Repositories\KostRepository;
use Illuminate\Http\Request;

class SearchServiceImpl implements SearchService
{
    protected $kostRepository;
    protected $areaRepository;

    public function __construct(
        KostRepository $kostRepository,
        AreaRepository $areaRepository
    ) {
        $this->kostRepository = $kostRepository;
        $this->areaRepository = $areaRepository;
    }

    public function searchKost(Request $request): SearchResource
    {
        $searchKey = $this->validateAndExtractSearchKey($request);
        if (!$searchKey) {
            return new SearchResource([]);
        }

        $searchResults = $this->buildSearchResults($searchKey);

        return new SearchResource($searchResults);
    }

    private function validateAndExtractSearchKey(Request $request): ?string
    {
        $key = $request->key;
        if (is_null($key) || mb_strlen($key) < 3) {
            return null;
        }
        return $key;
    }

    private function buildSearchResults(string $searchKey): array
    {
        return [
            'location' => $this->searchByLocation($searchKey),
            'kost_name' => $this->searchByKostName($searchKey),
            'price' => $this->searchByPrice($searchKey),
        ];
    }

    private function searchByLocation(string $searchKey): array
    {
        $areas = $this->areaRepository->searchAreasWithMatchingAreaName($searchKey);
        return $areas->map(function ($area) {
            return [$area->area_name => new KostSimpleCollection($area->kosts)];
        })->toArray();
    }

    private function searchByKostName(string $searchKey): array
    {
        $kosts = $this->kostRepository->searchKostWithMatchingKostName($searchKey);
        return $kosts->map(function ($kost) {
            return new KostSimpleResource($kost);
        })->toArray();
    }

    private function searchByPrice(string $searchKey): array
    {
        if (!ctype_digit($searchKey)) {
            return [];  // No result search for non-numeric keys
        }

        $priceRange = $this->calculatePriceRange($searchKey);
        $kosts = $this->kostRepository->searchKostInPriceRange($priceRange[0], $priceRange[1]);
        return $kosts->map(function ($kost) {
            return new KostSimpleResource($kost);
        })->toArray();
    }

    private function calculatePriceRange(int $price): array
    {
        $lowerPrice = $price - $price * 0.15; // Asumsi 15 percent
        $upperPrice = $price + $price * 0.15;
        return [$lowerPrice, $upperPrice];
    }
}