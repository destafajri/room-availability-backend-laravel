<?php

namespace App\Exceptions;

use App\Exceptions\ApiException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (ApiException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "error" => [
                        $e->getMessage()
                    ],
                ], $e->getCode());
            }
        });
    }
}
