<?php

namespace App\Repositories;

use App\Models\User;

interface TenantRepository
{
    public function saveNewTenantPrime(User $user): void;
}