<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

use CoenMooij\DevpoolApi\Infrastructure\Exceptions\DevpoolException;
use Illuminate\Http\Response;

final class LoginFailedException extends DevpoolException
{
    const MESSAGE = 'Login Failed';

    public function __construct()
    {
        parent::__construct(Response::HTTP_UNAUTHORIZED, self::MESSAGE);
    }
}
