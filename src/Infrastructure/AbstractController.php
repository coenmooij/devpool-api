<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Infrastructure;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

abstract class AbstractController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private const RESPONSE_MESSAGE_KEY = 'message';
    private const RESPONSE_DATA_KEY = 'data';
    private const RESPONSE_STATUS_CODE_KEY = 'code';

    public static function createResponse(int $statusCode, $data = null, string $message = null): JsonResponse
    {
        $responseBody = [
            self::RESPONSE_STATUS_CODE_KEY => $statusCode,
            self::RESPONSE_MESSAGE_KEY => $message ?? Response::$statusTexts[$statusCode],
        ];
        if ($data !== null) {
            $responseBody[self::RESPONSE_DATA_KEY] = $data;
        }

        return response()->json($responseBody, $statusCode);
    }
}
