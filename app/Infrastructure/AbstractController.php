<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Infrastructure;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

abstract class AbstractController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function createResponse($payload, int $statusCode): JsonResponse
    {
        return response()->json($payload, $statusCode);
    }
}
