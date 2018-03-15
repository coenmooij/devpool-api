<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Permission;

use CoenMooij\DevpoolApi\Authentication\User;
use Illuminate\Support\Facades\Auth;

final class PermissionService
{
    /**
     * @var User $user
     */
    private $user;

    public function __construct()
    {
        /**
         * @var User
         */
        $this->user = Auth::user();
    }

    public function ensureCanAccessDeveloper(int $id): void
    {
        if (!$this->canAccessDevelopers() && !$this->isDeveloper($id)) {
            throw new PermissionException();
        }
    }

    public function ensureCanAccessDevelopers(): void
    {
        if (!$this->canAccessDevelopers()) {
            throw new PermissionException();
        }
    }

    public function canAccessDevelopers(): bool
    {
        return $this->user->isAdmin() || $this->user->isBackofficeUser();
    }

    public function isDeveloper(int $id): bool
    {
        return $this->user->isDeveloper() && $this->user->{User::ID} === $id;
    }

    public function ensureIsAdmin(): void
    {
        if (!$this->user->isAdmin()) {
            throw new PermissionException();
        }
    }
}
