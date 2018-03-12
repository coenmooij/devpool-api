<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use CoenMooij\DevpoolApi\Infrastructure\IntEnum;

final class Speciality extends IntEnum
{
    public const FRONT_END = 'front-end';
    public const BACK_END = 'back-end';
    public const FULLSTACK = 'fullstack';
    public const MOBILE = 'mobile';
    public const DEVOPS = 'devops';
    public const UI_UX = 'ui/ux';

    protected const ALL = [
        self::FRONT_END => 1,
        self::BACK_END => 2,
        self::FULLSTACK => 3,
        self::MOBILE => 4,
        self::DEVOPS => 5,
        self::UI_UX => 6,
    ];
}
