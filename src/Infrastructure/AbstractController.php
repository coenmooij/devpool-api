<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Infrastructure;

use CoenMooij\DevpoolApi\Authentication\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

abstract class AbstractController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private const MESSAGE_KEY = 'message';
    private const DATA_KEY = 'data';
    private const STATUS_CODE_KEY = 'code';
    private const USER_KEY = 'user';

    public static function createResponse(int $statusCode, $data = null, string $message = null): JsonResponse
    {
        $responseBody = [
            self::STATUS_CODE_KEY => $statusCode,
            self::MESSAGE_KEY => $message ?? Response::$statusTexts[$statusCode],
        ];
        if ($data !== null) {
            $responseBody[self::DATA_KEY] = $data;
        }

        return response()->json($responseBody, $statusCode);
    }

    protected function getCurrentUser(Request $request): User
    {
        return $request->attributes->get(self::USER_KEY);
    }
}
