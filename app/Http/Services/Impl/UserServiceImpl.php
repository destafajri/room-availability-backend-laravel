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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

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

    public function tenantRegularRegister(Request $request): void
    {
        DB::transaction(function () use ($request) {
            try {
                $user = $this->findOrCreateTenant($request);
                $this->validateUserRegistration($user);

                $this->userRepository->registerUser($user);
                $this->tenantRepository->saveNewTenantRegular($user);

                $this->sendRegistrationEmail($user);
            } catch (\PDOException $e) {
                Log::info($e);
                throw new ApiException('Error when creating new tenant regular', 500);
            }
        });
    }

    public function userVerifyOtpRegistration(Request $request): ?string
    {
        $user = $this->findUserByEmail($request->email);
        $this->validateOtp($request, $user);

        $this->verifyUserEmail($user);
        $this->deleteOtpFromRedis($request->email);

        $this->loginUser($user);
        return $this->generateAuthToken($user, 'verify_register');
    }

    public function userLogin(Request $request): ?string
    {
        $user = $this->findUserByPhoneNumber($request->phone_number);
        $this->validatePassword($user, $request->password);
        $this->validateUserIsVerified($user);

        $this->loginUser($user);
        return $this->generateAuthToken($user, 'login_token');
    }

    public function userLogout(Request $request): void
    {
        $this->revokeUserAccessTokens($request);
        $this->clearRememberTokenIfExists($request->user());
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

    private function findUserByEmail(string $email): User
    {
        return $this->userRepository->findUserDetail("", $email, "") ?:
            throw new ApiException("User not found", 400);
    }

    private function findUserByPhoneNumber(string $phone_number): User
    {
        return $this->userRepository->findUserDetail("", "", $phone_number) ?:
            throw new ApiException("User not found", 400);
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

    private function validatePassword(User $user, string $password): void
    {
        if (!$user || !Hash::check($password, $user->password)) {
            throw new ApiException("Invalid credentials", 401);
        }
    }

    private function validateOtp(Request $request, User $user): void
    {
        $otpKey = $this->generateOtpKey($user->email);
        $storedOtp = Redis::get($otpKey);

        if ($request->otp !== $storedOtp) {
            throw new ApiException("OTP doesn't valid", 400);
        }
    }

    private function validateUserIsVerified(User $user): void
    {
        if (!$user->email_verified_at) {
            throw new ApiException("User hasn't verified email", 401);
        }
    }

    private function verifyUserEmail(User $user): void
    {
        $this->userRepository->verifyEmail($user);
    }

    private function sendRegistrationEmail(User $user): void
    {
        $userDetail = $this->userRepository->findUserDetail($user->id, $user->email, $user->phone_number);
        SendOtpEmailJob::dispatch($userDetail);
    }

    private function generateOtpKey(string $email): string
    {
        return "OTP-email_" . $email;
    }

    private function deleteOtpFromRedis(string $email): void
    {
        $otpKey = $this->generateOtpKey($email);
        Redis::del($otpKey);
    }

    private function loginUser(User $user): void
    {
        Auth::login($user, true);
    }

    private function generateAuthToken($user, $token_name)
    {
        return $user->createToken($token_name, ['*'], now()->addWeek())->plainTextToken;
    }

    private function revokeUserAccessTokens(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();
        // Consider deleting all tokens for thorough logout:
        // auth()->user()->tokens()->delete();
    }

    private function clearRememberTokenIfExists(User $user): void
    {
        if ($user->remember_token) {
            $user->remember_token = null;
            $user->save();
        }
    }
}