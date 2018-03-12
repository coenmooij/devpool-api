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

    public static function get(string $key): int
    {
        if (!isset(static::ALL[$key])) {
            throw new LogicException();
        }

        return static::ALL[$key];
    }

    public static function getName(int $key): string
    {
        $allNames = array_flip(static::ALL);
        if (!isset($allNames[$key])) {
            throw new LogicException();
        }

        return $allNames[$key];
    }
}
