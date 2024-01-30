<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

interface UserService
{
    public function ownerRegister(Request $request): void;
    public function tenantPrimeRegister(Request $request): void;
}