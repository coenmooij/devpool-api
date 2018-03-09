<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

use ReflectionClass;

abstract class AbstractTechnologyData implements TechnologyDataInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string[]
     */
    protected $parents = [];

    public function getAll(): array
    {
        $reflectionClass = new ReflectionClass($this);

        return $reflectionClass->getConstants();
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getParents(): array
    {
        return $this->parents;
    }
}
