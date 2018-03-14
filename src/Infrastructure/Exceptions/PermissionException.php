<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Infrastructure\Exceptions;

use Illuminate\Http\Response;

class PermissionException extends DevpoolException
{
    const DEFAULT_MESSAGE = 'Permission denied';

    public function __construct(string $message = self::DEFAULT_MESSAGE)
    {
        parent::__construct($message, Response::HTTP_FORBIDDEN);
    }
}
