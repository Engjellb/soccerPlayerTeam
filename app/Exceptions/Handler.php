<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Psr\Log\LogLevel;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use TypeError;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
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
    }

    /**
     * Override render method
     * Return errors in json format if requests are received from api, otherwise return on blade
     *
     * @param $request
     * @param Throwable $e
     * @return JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        if ($request->is('api/*')) {
            return $this->handleApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Return a custom message for a certain error that caused by app
     *
     * @param $request
     * @param Throwable $e
     * @return JsonResponse
     */
    private function handleApiException($request, Throwable $e): JsonResponse
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            $exception = $this->errorResponse(Response::HTTP_METHOD_NOT_ALLOWED, 'Invalid method for this url');

        } elseif ($e instanceof NotFoundHttpException) {
            $exception = $this->errorResponse(Response::HTTP_NOT_FOUND, 'Invalid url');

        } elseif ($e instanceof ModelNotFoundException) {
            $exception = $this->errorResponse(Response::HTTP_NOT_FOUND, $e->getMessage());

        } elseif ($e instanceof TypeError) {
            $exception = $this->errorResponse(Response::HTTP_BAD_REQUEST, 'Invalid data');

        } elseif ($e instanceof AuthenticationException) {
            $exception = $this->errorResponse(Response::HTTP_UNAUTHORIZED, $e->getMessage());

        } elseif ($e instanceof UnauthorizedException) {
            $exception = $this->errorResponse(Response::HTTP_FORBIDDEN, 'Unauthorized');

        } else {
            $exception = $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Something went wrong');
        }

        return $exception;
    }
}
