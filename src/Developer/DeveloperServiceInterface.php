<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer;

use CoenMooij\DevpoolApi\Authentication\User;
use Illuminate\Database\Eloquent\Collection;

interface DeveloperServiceInterface
{
    /**
     * @return Developer[]|Collection
     */
    public function getAll(): Collection;

    public function getOne(int $id): Developer;

    public function update(int $id, array $data): Developer;

    public function createDeveloperFromUser(User $user): Developer;
}
