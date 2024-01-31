<?php

namespace App\Http\Services;

use App\Http\Requests\Kost\CreateKostByOwnerRequest;

interface KostService
{
    public function createNewKostByOwner(CreateKostByOwnerRequest $createKostByOwnerRequest): void;
}