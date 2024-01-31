<?php

namespace App\Http\Controllers\Kost;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kost\CreateKostByOwnerRequest;
use App\Http\Requests\Kost\GetListKostRequest;
use App\Http\Services\KostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KostController extends Controller
{
    protected $kostService;

    public function __construct(KostService $kostService)
    {
        $this->kostService = $kostService;
    }

    public function createKostByOwner(CreateKostByOwnerRequest $createkostRequest): JsonResponse
    {
        $this->kostService->createNewKostByOwner($createkostRequest);

        return response()->json([
            "message" => "success create new kost"
        ], 200);
    }

    public function listKostByOwner(Request $request): JsonResource
    {
        return $this->kostService->listKostByOwner($request);
    }

    public function listKost(GetListKostRequest $request): JsonResource
    {
        return $this->kostService->listKost($request);
    }

    public function detailKost(Request $request): JsonResource
    {
        return $this->kostService->detailKost($request);
    }
}
