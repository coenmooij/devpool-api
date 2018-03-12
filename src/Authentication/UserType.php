<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

use CoenMooij\DevpoolApi\Infrastructure\IntEnum;

final class UserType extends IntEnum
{
    public const ADMIN = 'admin';
    public const BACKOFFICE = 'backoffice';
    public const DEVELOPER = 'developer';
    public const CLIENT = 'client';

    protected const ALL = [
        self::ADMIN => 0,
        self::BACKOFFICE => 1,
        self::DEVELOPER => 2,
        self::CLIENT => 3,
    ];
}
