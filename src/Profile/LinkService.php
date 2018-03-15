<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use Illuminate\Support\Collection;

final class LinkService implements LinkServiceInterface
{
    /**
     * @return Link[]|Collection
     */
    public function getByDeveloper(int $developerId): Collection
    {
        // TODO: Implement getByDeveloper() method.
    }

    /**
     * @return Link[]|Collection
     */
    public function getByType(string $type): Collection
    {
        // TODO: Implement getByType() method.
    }

    public function create(int $developerId, string $type, string $value): Link
    {
        // TODO: Implement create() method.
    }

    public function update(int $linkId, $value): Link
    {
        // TODO: Implement update() method.
    }

    public function delete(int $linkId): bool
    {
        // TODO: Implement delete() method.
    }
}
