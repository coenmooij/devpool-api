<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use CoenMooij\DevpoolApi\Infrastructure\IntEnum;

final class CommentType extends IntEnum
{
    public const TECHNICAL = 'technical';
    public const PRIORITY = 'priority';
    public const SALES = 'sales';
    public const SOCIAL = 'social';

    protected const ALL = [
        self::TECHNICAL => 1,
        self::PRIORITY => 2,
        self::SALES => 3,
        self::SOCIAL => 4,
    ];
}
