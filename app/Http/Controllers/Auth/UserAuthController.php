<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OwnerRegisterRequest;
use App\Http\Requests\Auth\TenantRegisterRequest;
use App\Http\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserAuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function ownerRegister(OwnerRegisterRequest $request): JsonResponse
    {
        $this->userService->ownerRegister($request);

        return response()->json([
            'message' => 'Success request owner register'
        ], 200);
    }

    public function tenantPrimeRegister(TenantRegisterRequest $request): JsonResponse
    {
        $this->userService->tenantPrimeRegister($request);

        return response()->json([
            'message' => 'Success request tenant prime register'
        ], 200);
    }

    public function tenantRegularRegister(TenantRegisterRequest $request): JsonResponse
    {
        $this->userService->tenantRegularRegister($request);

        return response()->json([
            'message' => 'Success request tenant regular register'
        ], 200);
    }
}
