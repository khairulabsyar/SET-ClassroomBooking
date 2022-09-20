<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // for front end response (web/json)
        $this->renderable(function (Throwable $e, $request) {

            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => "Have you watched Lost series? Yeah you are the missing character."
                ], 404);
            }

            // work if ModelNotFoundException is triggered
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => "Check your model bruh."
                ], 404);
            }
            // if ($request->is('api/*')) {
            //     return response()->json([
            //         'message' => 'Record not found.'
            //     ], 404);
            // }
        });
    }
}