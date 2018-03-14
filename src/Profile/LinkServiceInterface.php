<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use CoenMooij\DevpoolApi\Authentication\User;
use Illuminate\Support\Collection;

interface LinkServiceInterface
{
    /**
     * @return Link[]|Collection
     */
    public function getDeveloperLinksForUser(User $user, int $developerId): Collection;

    public function createDeveloperLink(User $user, $in): Link;
}
