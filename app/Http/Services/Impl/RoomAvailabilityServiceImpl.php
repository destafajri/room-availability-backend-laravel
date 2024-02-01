<?php

namespace App\Http\Services\Impl;

use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use App\Repositories\KostRepository;
use App\Http\Services\RoomAvailabilityService;
use App\Http\Resources\RoomAvailability\RoomAvailabilityResource;
use App\Models\Tenant;
use App\Repositories\TenantRepository;
use App\Repositories\UserRepository;

class RoomAvailabilityServiceImpl implements RoomAvailabilityService
{
    protected $userRepository;
    protected $tenantRepository;
    protected $kostRepository;

    public function __construct(
        UserRepository $userRepository,
        TenantRepository $tenantRepository,
        KostRepository $kostRepository
    ) {
        $this->userRepository = $userRepository;
        $this->tenantRepository = $tenantRepository;
        $this->kostRepository = $kostRepository;
    }

    public function askRoomAvailabilityService(Request $request): RoomAvailabilityResource
    {
        $user = $this->userRepository->currentAuthUser($request);
        $this->tenantRepository->reduceTenantCredit($user->tenant, 5);
        $kostId = $this->validateRequestIdAsInteger($request);
        $kost = $this->kostRepository->findKostDetailById($kostId);
        return new RoomAvailabilityResource($kost);
    }

    private function validateRequestIdAsInteger(Request $request): int
    {
        return ctype_digit($request->id)
            ? $request->id
            : throw new ApiException('Id Format Should be an Integer', 400);
    }
}