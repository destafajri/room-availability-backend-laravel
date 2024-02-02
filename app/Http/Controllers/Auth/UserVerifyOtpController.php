<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterVerifyRequest;
use App\Http\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserVerifyOtpController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(UserRegisterVerifyRequest $request): JsonResponse
    {
        $token = $this->userService->userVerifyOtpRegistration($request);

        return response()->json([
            'message' => "User success verify otp",
            'token' => $token
        ], 200);
    }
}

