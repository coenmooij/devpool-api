<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use CoenMooij\DevpoolApi\Infrastructure\IntEnum;

final class PipelineStatus extends IntEnum
{
    public const PROSPECT = 'prospect';
    public const PROFILE_INCOMPLETE = 'profile incomplete';
    public const PROFILE_REVIEW = 'profile review';
    public const CASPAR = 'caspar';
    public const POTENTIAL_CASPAR = 'potential';
    public const ICEBOX = 'icebox';
    public const BLACKLIST = 'blacklist';

    protected const ALL = [
        self::PROSPECT => 1,
        self::PROFILE_INCOMPLETE => 2,
        self::PROFILE_REVIEW => 3,
        self::CASPAR => 4,
        self::ICEBOX => 5,
        self::BLACKLIST => 6,
        self::POTENTIAL_CASPAR => 7,
    ];
}
