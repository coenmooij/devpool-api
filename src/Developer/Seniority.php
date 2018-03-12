<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use CoenMooij\DevpoolApi\Infrastructure\IntEnum;

final class Seniority extends IntEnum
{
    public const TRAINEE = 'trainee';
    public const JUNIOR = 'junior';
    public const JUNIOR_MEDIOR = 'junior/medior';
    public const MEDIOR = 'medior';
    public const MEDIOR_SENIOR = 'medior/senior';
    public const SENIOR = 'senior';
    public const SENIOR_LEAD = 'senior/lead';
    public const LEAD = 'lead';
    public const SENIOR_ARCHITECT = 'senior/architect';
    public const ARCHITECT = 'architect';

    protected const ALL = [
        self::TRAINEE => 1,
        self::JUNIOR => 2,
        self::JUNIOR_MEDIOR => 3,
        self::MEDIOR => 4,
        self::MEDIOR_SENIOR => 5,
        self::SENIOR => 6,
        self::SENIOR_LEAD => 7,
        self::SENIOR_ARCHITECT => 8,
        self::LEAD => 9,
        self::ARCHITECT => 10,
    ];
}
