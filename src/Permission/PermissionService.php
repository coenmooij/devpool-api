<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Permission;

use CoenMooij\DevpoolApi\Authentication\User;
use Illuminate\Support\Facades\Auth;

final class PermissionService implements PermissionServiceInterface
{
    /**
     * @var User $user
     */
    private $user;

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
        return $this->isAdminOrBackofficeUser();
    }

    public function isDeveloper(int $id): bool
    {
        return $this->getUser()->isDeveloper() && $this->isUser($id);
    }

    public function ensureIsAdmin(): void
    {
        if (!$this->getUser()->isAdmin()) {
            throw new PermissionException();
        }
    }

    public function ensureIsAdminOrBackofficeUser(): void
    {
        if (!$this->isAdminOrBackofficeUser()) {
            throw new PermissionException();
        }
    }

    public function ensureIsAdminOrUser(int $userId): void
    {
        if (!$this->getUser()->isAdmin() && !$this->isUser($userId)) {
            throw new PermissionException();
        }
    }

    public function isUser(int $id): bool
    {
        return $this->getUser()->{User::ID} === $id;
    }

    public function isAdminOrBackofficeUser(): bool
    {
        return $this->getUser()->isAdmin() || $this->getUser()->isBackofficeUser();
    }

    public function getLoggedInUserId(): int
    {
        return $this->getUser()->{User::ID};
    }

    private function getUser(): User
    {
        return $this->user ?? $this->user = Auth::user();
    }
}
