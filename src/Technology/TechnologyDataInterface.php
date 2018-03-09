<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

interface TechnologyDataInterface
{
    /**
     * @return string[]
     */
    public function getAll(): array;

    public function getType(): string;

    /**
     * @return string[]
     */
    public function getParents(): array;
}
