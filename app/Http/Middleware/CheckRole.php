<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if (!auth()->check()) {
            return response()->json([
                'error' => [
                    'Unauthorized'
                ]
            ], 401);
        }

        if (auth()->user()->role->role_name != $roles) {
            return response()->json([
                'error' => [
                    "You're not Allowed"
                ]
            ], 403);
        }

        $tokenId = $request->bearerToken();
        $token = PersonalAccessToken::findToken($tokenId);
        $userId = $token->tokenable_id;
        $user = User::find($userId);
        Log::info('auth request by usernane is ' . $user->username . ' on ' . Carbon::now());

        return $next($request);
    }
}
