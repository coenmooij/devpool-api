<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use CoenMooij\DevpoolApi\Infrastructure\IntEnum;

final class LinkType extends IntEnum
{
    public const FACEBOOK = 'facebook';
    public const GITHUB = 'github';
    public const GITLAB = 'gitlab';
    public const BITBUCKET = 'bitbucket';
    public const TWITTER = 'twitter';
    public const AVATAR = 'avatar';
    public const WEBSITE = 'website';
    public const LINKEDIN = 'linkedin';
    public const INSTAGRAM = 'instagram';

    protected const ALL = [
        self::FACEBOOK => 1,
        self::GITHUB => 2,
        self::GITLAB => 3,
        self::BITBUCKET => 4,
        self::TWITTER => 5,
        self::AVATAR => 6,
        self::WEBSITE => 7,
        self::LINKEDIN => 8,
        self::INSTAGRAM => 9,
    ];
}
