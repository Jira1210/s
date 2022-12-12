<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {
        // return parent: :render($request, $exception);
        if ($exception instanceof \Laravel\Sanctum\Exceptions\MissingAbilityException)
        {
            return response()->json
            (
                [
                    'errors' => [
                        'status' => 401,
                        'message' => 'Unauthenticated',
                    ]
                ],401 
            );
                        
        }
        $e = $this->prepareException($exception);
        if ($e instanceof HttpResponseException) 
        {
            return $e->getResponse();
        }
        elseif ($e instanceof AuthenticationException) 
        {
            return $this->aunauthenticated($request, $e);
        }
        elseif ($e instanceof ValidationException) 
        {
            return$this->convertValidationExceptionToResponse($e, $request);
        }

        return $this->prepareResponse($request, $e);
    }


    protected function aunauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    
}
