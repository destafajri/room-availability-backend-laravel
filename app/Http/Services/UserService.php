<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

interface UserService
{
    public function ownerRegister(Request $request): void;
    public function tenantPrimeRegister(Request $request): void;
    public function tenantRegularRegister(Request $request): void;
    public function userVerifyOtpRegistration(Request $request): ?string;
    public function userLogin(Request $request): ?string;
}