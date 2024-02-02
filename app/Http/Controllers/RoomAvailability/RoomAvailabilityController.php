<?php

namespace App\Http\Controllers\RoomAvailability;

use App\Http\Controllers\Controller;
use App\Http\Services\RoomAvailabilityService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomAvailabilityController extends Controller
{
    protected $roomAvailabilityService;

    public function __construct(RoomAvailabilityService $roomAvailabilityService) {
        $this->roomAvailabilityService = $roomAvailabilityService;
    }

    public function askRoom(Request $request): JsonResource
    {
        return $this->roomAvailabilityService->askRoomAvailabilityService($request);
    }
}
