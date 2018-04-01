<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

use CoenMooij\DevpoolApi\Developer\Developer;
use CoenMooij\DevpoolApi\Permission\PermissionServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

final class TechnologyService implements TechnologyServiceInterface
{
    private const ATTACHING_TECHNOLOGIES_ERROR = 'Something went wrong attaching technologies to a developer';
    /**
     * @var PermissionServiceInterface
     */
    private $permissionService;

    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @return Technology[]|Collection
     */
    public function getAll(): Collection
    {
        return Technology::all();
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
        try {
            $developer->technologies()->attach($technologyIdList);
        } catch (Exception $exception) {
            Log::warning(self::ATTACHING_TECHNOLOGIES_ERROR);
        }

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
