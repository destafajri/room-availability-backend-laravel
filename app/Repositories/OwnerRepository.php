<?php

namespace App\Repositories;

use App\Models\User;

interface OwnerRepository
{
    public function saveOwner(User $user): void;
}