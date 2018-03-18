<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer;

use CoenMooij\DevpoolApi\Authentication\User;
use CoenMooij\DevpoolApi\Permission\PermissionException;
use CoenMooij\DevpoolApi\Permission\PermissionServiceInterface;
use CoenMooij\DevpoolApi\Profile\PipelineStatus;
use CoenMooij\DevpoolApi\Profile\Seniority;
use CoenMooij\DevpoolApi\Profile\Speciality;
use Illuminate\Database\Eloquent\Collection;

final class DeveloperService implements DeveloperServiceInterface
{
    private const BACKOFFICE_EXTRA_FIELDS = [
        'technologies',
        'links',
        'answers',
        'answers.question',
        'answers.question.form',
        'comments',
        'comments.author',
    ];

    private const DEVELOPER_EXTRA_FIELDS = [
        'technologies',
        'links',
        'answers',
        'answers.question',
        'answers.question.form',
    ];

    private const ORDER_DESCENDING = 'desc';

    /**
     * @var PermissionServiceInterface
     */
    private $permissionService;

    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @return Developer[]|Collection
     */
    public function getAll(): Collection
    {
        $this->permissionService->ensureCanAccessDevelopers();

        return Developer::with(['technologies'])->orderBy(Developer::PRIORITY, self::ORDER_DESCENDING)->get();
    }

    public function getOne(int $id): Developer
    {
        if ($this->permissionService->isDeveloper($id)) {
            return Developer::with(self::DEVELOPER_EXTRA_FIELDS)->findOrFail($id);
        }
        if ($this->permissionService->isAdminOrBackofficeUser()) {
            return Developer::with(self::BACKOFFICE_EXTRA_FIELDS)->findOrFail($id);
        }
        throw new PermissionException();
    }

    public function createDeveloperFromUser(User $user): Developer
    {
        $developer = new Developer();
        $developer->{Developer::ID} = $user->{User::ID};

        $developer->saveOrFail();

        return $developer;
    }

    public function update(int $developerId, array $data): Developer
    {
        $this->permissionService->ensureCanAccessDeveloper($developerId);

        $developer = Developer::findOrFail($developerId);

        foreach ($data as $key => $value) {
            $developer->$key = $value;
        }
        $developer->saveOrFail();

        return $developer;
    }
}
