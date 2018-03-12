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

    public function get($key): int
    {
        if (!isset(self::ALL[$key])) {
            throw new LogicException();
        }

        return self::ALL[$key];
    }
}
