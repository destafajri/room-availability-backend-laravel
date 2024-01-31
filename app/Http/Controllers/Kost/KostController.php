<?php

namespace App\Http\Controllers\Kost;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kost\CreateKostByOwnerRequest;
use App\Http\Services\KostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KostController extends Controller
{
    protected $kostService;

    public function __construct(KostService $kostService)
    {
        $this->kostService = $kostService;
    }

    public function createKostByOwner(CreateKostByOwnerRequest $createkostRequest): JsonResponse
    {
        $this->kostService->createNewkostByOwner($createkostRequest);

        return response()->json([
            "message" => "success create new kost"
        ], 200);
    }
}
