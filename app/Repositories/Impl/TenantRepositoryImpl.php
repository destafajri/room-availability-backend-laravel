<?php

namespace App\Repositories\Impl;

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
}