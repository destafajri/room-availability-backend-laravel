<?php

namespace App\Http\Resources\Kost;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KostSimpleResource extends JsonResource
{
    public static $wrap = '';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kost_name' => $this->kost_name,
            'price' => $this->price,
            'address' => $this->address,
        ];
    }
}
