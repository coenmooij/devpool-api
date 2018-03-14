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
    public function getAllForUser(User $user): Collection;

    public function getOneForUser(User $user, int $id): Developer;

    public function createDeveloperFromUser(User $user): Developer;
}
