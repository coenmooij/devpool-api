<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Infrastructure;

use LogicException;

abstract class IntEnum
{
    /**
     * Override this in your implementation
     * @var array
     */
    protected const ALL = [];
    private const INVALID_NAME = 'Invalid name for enum';
    private const INVALID_KEY = 'Invalid key for enum';

    public static function get(string $key): int
    {
        if (!isset(static::ALL[$key])) {
            throw new LogicException(self::INVALID_NAME);
        }

        return static::ALL[$key];
    }

    public static function getName(int $key): string
    {
        $allNames = array_flip(static::ALL);
        if (!isset($allNames[$key])) {
            throw new LogicException(self::INVALID_KEY);
        }

        return $allNames[$key];
    }
}
