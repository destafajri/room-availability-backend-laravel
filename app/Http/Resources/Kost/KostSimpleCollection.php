<?php

namespace App\Http\Resources\Kost;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class KostSimpleCollection extends ResourceCollection
{
    public static $wrap = '';

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            KostSimpleResource::collection($this->collection)
        ];
    }
}
