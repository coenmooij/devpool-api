<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use Illuminate\Database\Eloquent\Collection;

interface LinkServiceInterface
{
    /**
     * @return Link[]|Collection
     */
    public function getByDeveloper(int $developerId): Collection;

    /**
     * @return Link[]|Collection
     */
    public function getByType(string $type): Collection;

    public function getOne(int $linkId): Link;

    public function create(int $developerId, string $type, string $value): Link;

    public function update(int $linkId, string $value): Link;

    public function delete(int $linkId): bool;
}
