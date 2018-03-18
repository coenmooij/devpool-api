<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Permission;

interface PermissionServiceInterface
{
    public function ensureCanAccessDeveloper(int $id): void;

    public function ensureCanAccessDevelopers(): void;

    public function canAccessDevelopers(): bool;

    public function isDeveloper(int $id): bool;

    public function ensureIsAdmin(): void;

    public function ensureIsAdminOrBackofficeUser(): void;

    public function ensureIsAdminOrUser(int $userId): void;

    public function isUser(int $id): bool;

    public function isAdminOrBackofficeUser(): bool;
}
