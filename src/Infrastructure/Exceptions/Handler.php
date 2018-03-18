<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Infrastructure\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     * @var array
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     * @var array
     */
    protected $dontFlash = [
        'password',
    ];

    public function render($request, Exception $exception): JsonResponse
    {
        $request->headers->set('Accept', '/json');

        return parent::render($request, $exception);
    }
}