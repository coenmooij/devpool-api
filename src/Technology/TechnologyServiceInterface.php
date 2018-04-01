<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

use Illuminate\Database\Eloquent\Collection;

interface TechnologyServiceInterface
{
    /**
     * @return Technology[]|Collection
     */
    public function getAll(): Collection;

    /**
     * @return Technology[]|Collection
     */
    public function getByDeveloper(int $developerId): Collection;

    /**
     * @return Technology[]|Collection
     */
    public function addToDeveloper(int $developerId, int ...$technologyIdList): Collection;

    /**
     * @return Technology[]|Collection
     */
    public function removeFromDeveloper(int $developerId, int ...$technologyIdList): Collection;
}
