<?php

namespace App\Http\Resources\RoomAvailability;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomAvailabilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'room_message' => $this->getMessage()
        ];
    }

    private function getMessage(): string
    {
        $room = $this->room_available;
        $availableMsg = "Haii! Rooms are open! $room spots left. Don't miss out! Book now!";
        $fullyBookedMsg = 'We are so sorry that our room is already fully booked.';
        return $room != 0 ? $availableMsg : $fullyBookedMsg;
    }
}
