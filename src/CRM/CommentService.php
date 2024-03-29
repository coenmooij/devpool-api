<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\CRM;

use CoenMooij\DevpoolApi\Authentication\User;
use CoenMooij\DevpoolApi\Permission\PermissionServiceInterface;
use CoenMooij\DevpoolApi\Profile\CommentType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class CommentService implements CommentServiceInterface
{
    private const DESCENDING = 'desc';

    /**
     * @var PermissionServiceInterface
     */
    private $permissionService;

    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @return Comment[]|Collection
     */
    public function getByDeveloper(int $developerId): Collection
    {
        $this->permissionService->ensureIsAdminOrBackofficeUser();

        return Comment::where(Comment::USER_ID, $developerId)
            ->with(['author', 'author.links'])
            ->orderBy(Comment::CREATED_AT, self::DESCENDING)
            ->get();
    }

    public function getOne(int $commentId): Comment
    {
        $this->permissionService->ensureIsAdminOrBackofficeUser();

        return Comment::with(['author', 'author.links'])->findOrFail($commentId);
    }

    public function create(int $developerId, string $message): Comment
    {
        $this->permissionService->ensureIsAdminOrBackofficeUser();

        $comment = new Comment();
        $comment->{Comment::USER_ID} = $developerId;
        $comment->{Comment::AUTHOR_ID} = $this->permissionService->getLoggedInUserId();
        $comment->{Comment::MESSAGE} = $message;
        $comment->saveOrFail();

        return $comment->load(['author']);
    }

    public function update(int $commentId, string $message): Comment
    {
        /** @var Comment $comment */
        $comment = Comment::findOrFail($commentId);
        $this->permissionService->ensureIsAdminOrUser($comment->{Comment::AUTHOR_ID});
        $comment->{Comment::MESSAGE} = $message;
        $comment->saveOrFail();

        return $comment->load(['author']);
    }

    public function delete(int $commentId): bool
    {
        $this->permissionService->ensureIsAdmin();

        /** @var Comment $comment */
        $comment = Comment::findOrFail($commentId);

        return $comment->delete();
    }
}
