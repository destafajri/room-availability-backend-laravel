<?php

namespace App\Http\Services;

use App\Http\Resources\RoomAvailability\RoomAvailabilityResource;
use Illuminate\Http\Request;

interface RoomAvailabilityService
{
    public function askRoomAvailabilityService(Request $request): RoomAvailabilityResource;
}