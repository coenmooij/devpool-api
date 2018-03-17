<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

use CoenMooij\DevpoolApi\Developer\Developer;
use CoenMooij\DevpoolApi\Permission\PermissionService;
use Illuminate\Database\Eloquent\Collection;

final class TechnologyService implements TechnologyServiceInterface
{
    /**
     * @var PermissionService
     */
    private $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @return Technology[]|Collection
     */
    public function getByDeveloper(int $developerId): Collection
    {
        $this->permissionService->ensureCanAccessDeveloper($developerId);

        /** @var Developer $developer */
        $developer = Developer::findOrFail($developerId);

        return $developer->technologies()->get();
    }

    /**
     * @return Technology[]|Collection
     */
    public function addToDeveloper(int $developerId, int ...$technologyIdList): Collection
    {
        $this->permissionService->ensureCanAccessDeveloper($developerId);

        /** @var Developer $developer */
        $developer = Developer::findOrFail($developerId);
        $developer->technologies()->attach($technologyIdList);

        return $developer->technologies()->get();
    }

    /**
     * @return Technology[]|Collection
     */
    public function removeFromDeveloper(int $developerId, int ...$technologyIdList): Collection
    {
        $this->permissionService->ensureCanAccessDeveloper($developerId);

        /** @var Developer $developer */
        $developer = Developer::findOrFail($developerId);
        $developer->technologies()->detach($technologyIdList);

        return $developer->technologies()->get();
    }
}
