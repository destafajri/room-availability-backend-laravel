<?php

namespace App\Http\Services\Impl;

use App\Exceptions\ApiException;
use App\Http\Requests\Kost\CreateKostByOwnerRequest;
use App\Http\Services\KostService;
use App\Models\Kost;
use App\Models\Owner;
use App\Repositories\KostFacilityRepository;
use App\Repositories\KostRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KostServiceImpl implements KostService
{
    protected $userRepository;
    protected $kostRepository;
    protected $kostFacilityRepository;

    public function __construct(
        UserRepository $userRepository,
        KostRepository $kostRepository,
        KostFacilityRepository $kostFacilityRepository
    ) {
        $this->userRepository = $userRepository;
        $this->kostRepository = $kostRepository;
        $this->kostFacilityRepository = $kostFacilityRepository;
    }

    public function createNewKostByOwner(CreateKostByOwnerRequest $request): void
    {
        DB::transaction(function () use ($request) {
            try {
                $owner = $this->getCurrentAuthOwner($request);
                $kost = $this->createKostByOwnerModel($request, $owner);
                $this->kostFacilityRepository->attachKostFacilities($kost, $request->facilities);
            } catch (\PDOException $e) {
                Log::info($e);
                throw new ApiException('Error when creating new kost', 500);
            }
        });
    }
    
    private function getCurrentAuthOwner(Request $request): Owner
    {
        $user = $this->userRepository->currentAuthUser($request);
        return $user->owner;
    }

    private function createKostByOwnerModel(Request $request, Owner $owner): Kost
    {
        $kost = new Kost();
        $kost->kost_name = $request->kost_name;
        $kost->price = $request->price;
        $kost->owner_id = $owner->id;
        $kost->kost_gender_id = $request->gender_id;
        $kost->area_id = $request->area_id;
        $kost->address = $request->address;
        $kost->description = $request->description;
        $kost->room_total = $request->room_total;
        $kost->room_available = $request->room_available;
        $this->kostRepository->saveNewKost($kost);
        return $kost;
    }
}