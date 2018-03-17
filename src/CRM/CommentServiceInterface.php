<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\CRM;

use Illuminate\Database\Eloquent\Collection;

interface CommentServiceInterface
{
    /**
     * @return Comment[]|Collection
     */
    public function getByDeveloper(int $developerId): Collection;

    public function getOne(int $commentId): Comment;

    public function create(int $developerId, string $type, string $message): Comment;

    public function update(int $commentId, string $message): Comment;

    public function delete(int $commentId): bool;
}
