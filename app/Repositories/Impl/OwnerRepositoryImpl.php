<?php

namespace App\Repositories\Impl;

use App\Models\Owner;
use App\Models\User;
use App\Repositories\OwnerRepository;
use Illuminate\Support\Facades\DB;

class OwnerRepositoryImpl implements OwnerRepository
{
    public function saveOwner(User $user): void
    {
        $owner = new Owner();
        $owner->user_id = $user->id;
        $owner->save();
    }
}