<?php

namespace App\Http\Services\Impl;

use App\Exceptions\ApiException;
use App\Http\Services\UserService;
use App\Jobs\SendOtpEmailJob;
use App\Models\User;
use App\Repositories\OwnerRepository;
use App\Repositories\TenantRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserServiceImpl implements UserService
{
    protected $userRepository;
    protected $tenantRepository;
    protected $ownerRepository;

    public function __construct(
        UserRepository $userRepository,
        TenantRepository $tenantRepository,
        OwnerRepository $ownerRepository
    ) {
        $this->userRepository = $userRepository;
        $this->tenantRepository = $tenantRepository;
        $this->ownerRepository = $ownerRepository;
    }

    public function ownerRegister(Request $request): void
    {
        DB::transaction(function () use ($request) {
            try {
                $user = $this->findOrCreateOwner($request);
                $this->validateUserRegistration($user);

                $this->userRepository->registerUser($user);
                $this->ownerRepository->saveOwner($user);

                $this->sendRegistrationEmail($user);
            } catch (\PDOException $e) {
                Log::info($e);
                throw new ApiException('Error when creating new owner', 500);
            }
        });
    }

    public function tenantPrimeRegister(Request $request): void
    {
        DB::transaction(function () use ($request) {
            try {
                $user = $this->findOrCreateTenant($request);
                $this->validateUserRegistration($user);

                $this->userRepository->registerUser($user);
                $this->tenantRepository->saveNewTenantPrime($user);

                $this->sendRegistrationEmail($user);
            } catch (\PDOException $e) {
                Log::info($e);
                throw new ApiException('Error when creating new tenant prime', 500);
            }
        });
    }

    private function findOrCreateTenant(Request $request): User
    {
        return $this->userRepository->findUserDetailWithTrash($request->email, $request->phone_number) ?: new User([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);
    }

    private function findOrCreateOwner(Request $request): User
    {
        return $this->userRepository->findUserDetailWithTrash($request->email, $request->phone_number) ?: new User([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1,
        ]);
    }

    private function validateUserRegistration(User $user): void
    {
        if ($this->userRepository->isUserRegistered($user)) {
            throw new ApiException("User already registered", 400);
        }

        if ($this->userRepository->isUserWaitingForDeletion($user)) {
            throw new ApiException("Please wait 2 days after request delete", 400);
        }
    }

    private function sendRegistrationEmail(User $user): void
    {
        $userDetail = $this->userRepository->findUserDetail($user->id, $user->email, $user->phone_number);
        SendOtpEmailJob::dispatch($userDetail);
    }
}