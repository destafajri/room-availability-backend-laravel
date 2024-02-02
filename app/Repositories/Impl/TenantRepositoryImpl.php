<?php

namespace App\Repositories\Impl;

use App\Exceptions\ApiException;
use App\Models\Tenant;
use App\Models\User;
use App\Repositories\TenantRepository;
use Illuminate\Support\Facades\DB;

class TenantRepositoryImpl implements TenantRepository
{
    public function saveNewTenantPrime(User $user): void
    {
        $tenant = new Tenant();
        $tenant->user_id = $user->id;
        $tenant->is_prime = true;
        $tenant->credit = 40;
        $tenant->save();
    }

    public function saveNewTenantRegular(User $user): void
    {
        $tenant = new Tenant();
        $tenant->user_id = $user->id;
        $tenant->is_prime = false;
        $tenant->credit = 20;
        $tenant->save();
    }

    public function reduceTenantCredit(Tenant $tenant, int $pointReduction): void
    {
        if ($tenant->credit < $pointReduction) {
            throw new ApiException("Credit is not enough, your credit is $tenant->credit", 422);
        }
        $tenant->credit -= $pointReduction;
        $tenant->save();
    }
}