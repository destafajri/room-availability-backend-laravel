<?php

namespace App\Http\Services\Impl;

use App\Exceptions\ApiException;
use App\Http\Requests\Kost\CreateKostByOwnerRequest;
use App\Http\Requests\Kost\GetListKostRequest;
use App\Http\Requests\Kost\UpdateKostByOwnerRequest;
use App\Http\Resources\Kost\KostCollection;
use App\Http\Resources\Kost\KostResource;
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

    public function listKostByOwner(Request $request): KostCollection
    {
        $owner = $this->getCurrentAuthOwner($request);
        $kost = $this->kostRepository->findListKostByOwner($request, $owner);
        return new KostCollection($kost);
    }

    public function listKost(GetListKostRequest $request): KostCollection
    {
        $kost = is_null($request->id)
            ? $this->kostRepository->findAllKostListings($request)
            : $this->kostRepository->findKostListingsByIds($request);
        return new KostCollection($kost);
    }

    public function detailKost(Request $request): KostResource
    {
        $id = ctype_digit($request->id) ? $request->id : throw new ApiException('Id Format Should be an Integer', 400);
        $kost = $this->kostRepository->findKostDetailById($id);
        return new KostResource($kost);
    }

    public function updateKostByOwner(UpdateKostByOwnerRequest $request): void
    {
        DB::transaction(function () use ($request) {
            try {
                $id = ctype_digit($request->id)
                    ? $request->id
                    : throw new ApiException('Id Format Should be an Integer', 400);
                $kost = $this->kostRepository->findKostDetailById($id);
                $owner = $this->getCurrentAuthOwner($request);
                $this->ensureOwnership($kost, $owner);
                $this->updateKostByOwnerModel($request, $kost);
                if (!is_null($request->facilities)) {
                    $this->updateKostFacilities($kost, $request->facilities);
                }
            } catch (\PDOException $e) {
                Log::info($e);
                throw new ApiException('Error when updating kost', 500);
            }
        });
    }

    public function deleteKostByOwner(Request $request): void
    {
        DB::transaction(function () use ($request) {
            try {
                $id = ctype_digit($request->id)
                    ? $request->id
                    : throw new ApiException('Id Format Should be an Integer', 400);
                $kost = $this->kostRepository->findKostDetailById($id);
                $owner = $this->getCurrentAuthOwner($request);
                $this->ensureOwnership($kost, $owner);
                $this->kostRepository->deleteKost($kost);
            } catch (\PDOException $e) {
                Log::info($e);
                throw new ApiException('Error when delete kost', 500);
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

    private function updateKostByOwnerModel(Request $request, Kost $kost): Kost
    {
        $kost->kost_name = $request->kost_name ?: $kost->kost_name;
        $kost->price = $request->price ?: $kost->price;
        $kost->kost_gender_id = $request->gender_id ?: $kost->kost_gender_id;
        $kost->area_id = $request->area_id ?: $kost->area_id;
        $kost->address = $request->address ?: $kost->address;
        $kost->description = $request->description ?: $kost->description;
        $kost->room_total = $request->room_total ?: $kost->room_total;
        $kost->room_available = $request->room_available ?: $kost->room_available;
        $this->kostRepository->updateKost($kost);
        return $kost;
    }

    private function updateKostFacilities(Kost $kost, array $facilities): void
    {
        $this->kostFacilityRepository->detachAllKostFacilities($kost);
        $this->kostFacilityRepository->attachKostFacilities($kost, $facilities);
    }

    private function ensureOwnership(Kost $kost, Owner $owner): void
    {
        if ($kost->owner_id != $owner->id) {
            throw new ApiException("You're Not Allowed to edit this kost", 403);
        }
    }
}