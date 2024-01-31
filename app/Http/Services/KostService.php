<?php

namespace App\Http\Services;

use App\Http\Requests\Kost\CreateKostByOwnerRequest;
use App\Http\Requests\Kost\GetListKostRequest;
use App\Http\Resources\Kost\KostCollection;
use App\Http\Resources\Kost\KostResource;
use Illuminate\Http\Request;

interface KostService
{
    public function createNewKostByOwner(CreateKostByOwnerRequest $createKostByOwnerRequest): void;
    public function listKostByOwner(Request $request): KostCollection;
    public function listKost(GetListKostRequest $getListKostRequest): KostCollection;
    public function detailKost(Request $getListKostRequest): KostResource;
}