<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

use ReflectionClass;

abstract class AbstractTechnologyData
{
    public function getAll(): array
    {
        $reflectionClass = new ReflectionClass($this);

        return $reflectionClass->getConstants();
    }
}
