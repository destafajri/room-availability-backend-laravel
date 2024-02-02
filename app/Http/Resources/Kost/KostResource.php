<?php

namespace App\Http\Resources\Kost;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Sanctum\PersonalAccessToken;

class KostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $data = $this->baseData();

        if ($this->isOwner($request)) {
            $data['room_available'] = $this->room_available;
        }

        return $data;
    }

    private function baseData(): array
    {
        return [
            'id' => $this->id,
            'kost_name' => $this->kost_name,
            'owner' => $this->owner->user->name,
            'price' => $this->price,
            'address' => $this->address,
            'description' => $this->description,
            'room_total' => $this->room_total,
            'is_active' => $this->is_active,
            'kost_gender' => $this->kostGender->gender_type,
            'area' => $this->area->area_name,
            'facilities' => $this->facilities->pluck('facility_name'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function isOwner(Request $request): bool
    {
        if ($request->bearerToken() == null) {
            return false;
        }
        $tokenId = $request->bearerToken();
        $token = PersonalAccessToken::findToken($tokenId);
        $userId = $token->tokenable_id;
        $user = User::find($userId);
        return $user->role->role_name == 'OWNER';
    }
}
