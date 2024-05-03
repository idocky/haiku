<?php

namespace App\Exceptions;

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
        $this->reportable(function (CustomException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        });


    }

    public function render($request, CustomException|Throwable $e)
    {
        if ($e instanceof QueryException) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return parent::render($request, $e);
    }
}
