<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

interface UserRepository
{
    public function currentAuthUser(Request $request): User;
    public function isUserRegistered(User $user): bool;
    public function isUserWaitingForDeletion(User $user): bool;
    public function findUserDetailWithTrash($email, $username): ?User;
    public function findUserDetail($id, $email, $username): ?User;
    public function registerUser(User $user): void;
    public function verifyEmail(User $user): void;
}