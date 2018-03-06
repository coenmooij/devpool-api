<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

use Symfony\Component\HttpKernel\Exception\HttpException;

final class LoginFailedException extends HttpException
{
    const MESSAGE = 'Login Failed';

    public function __construct()
    {
        parent::__construct(401, self::MESSAGE);
    }
}
