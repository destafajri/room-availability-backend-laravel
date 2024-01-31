<?php

namespace App\Http\Resources\Kost;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            "kost_name" => $this->kost_name,
            "owner" => $this->owner->user->name,
            'price' => $this->price,
            'address' => $this->address,
            'description' => $this->description,
            'room_total' => $this->room_total,
            'room_available' => $this->room_available,
            'is_active' => $this->is_active,
            'kost_gender' => $this->kostGender->gender_type,
            'area' => $this->area->area_name,
            'facilities' => $this->facilities->pluck('facility_name'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
