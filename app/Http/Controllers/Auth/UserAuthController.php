<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\OwnerRegisterRequest;
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

}
