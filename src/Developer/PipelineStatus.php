<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use CoenMooij\DevpoolApi\Infrastructure\IntEnum;

final class PipelineStatus extends IntEnum
{
    public const PROSPECT = 'prospect';
    public const PROFILE_INCOMPLETE = 'profile incomplete';
    public const PROFILE_REVIEW = 'profile review';
    public const TECHNICAL_INTERVIEW = 'technical interview';
    public const CASPAR = 'caspar';
    public const ICEBOX = 'icebox';
    public const BLACKLIST = 'blacklist';

    protected const ALL = [
        self::PROSPECT => 0,
        self::PROFILE_INCOMPLETE => 1,
        self::PROFILE_REVIEW => 2,
        self::TECHNICAL_INTERVIEW => 3,
        self::CASPAR => 4,
        self::ICEBOX => 5,
        self::BLACKLIST => 6,

    ];
}
