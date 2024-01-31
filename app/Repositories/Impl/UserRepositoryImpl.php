<?php

namespace App\Repositories\Impl;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class UserRepositoryImpl implements UserRepository
{
    public function currentAuthUser(Request $request): User
    {
        $tokenId = $request->bearerToken(); // Using Sanctum's request helper
        $token = PersonalAccessToken::findToken($tokenId);
        $userId = $token->tokenable_id;
        return User::find($userId);
    }

    public function isUserRegistered(User $user): bool
    {
        // checking if user already verified and registered
        $user = DB::select("
                SELECT 1 FROM users
                WHERE email = ? 
                AND email_verified_at is not null
                AND deleted_at is null
                LIMIT 1
            ", [
            $user->email
        ]);

        return count($user) == 1 ? true : false;
    }

    public function isUserWaitingForDeletion(User $user): bool
    {
        // checking if users already deleted 2 days
        $user = DB::select("
                SELECT 1 FROM users
                    WHERE email = ?
                    AND deleted_at IS NOT NULL
                    AND deleted_at >= ?
                    LIMIT 1
            ", [
            $user->email,
            Carbon::now()->subDay(2)
        ]);

        return count($user) == 1 ? true : false;
    }

    public function findUserDetailWithTrash($email, $phone_number): ?User
    {
        return User::withTrashed()
            ->where('email', $email)
            ->orWhere('phone_number', $phone_number)
            ->first();
    }

    public function findUserDetail($id, $email, $phone_number): ?User
    {
        return User::where('id', $id)
            ->orWhere('email', $email)
            ->orWhere('phone_number', $phone_number)
            ->first();
    }

    public function registerUser(User $user): void
    {
        $user->email_verified_at = null;
        $user->deleted_at = null;
        $user->save();
    }

    public function verifyEmail(User $user): void
    {
        $user->email_verified_at = Carbon::now();
        $user->save();
    }
}