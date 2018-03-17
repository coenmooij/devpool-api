<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\CRM;

use CoenMooij\DevpoolApi\Authentication\User;
use CoenMooij\DevpoolApi\Permission\PermissionService;
use CoenMooij\DevpoolApi\Profile\CommentType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class CommentService implements CommentServiceInterface
{
    /**
     * @var PermissionService
     */
    private $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @return Comment[]|Collection
     */
    public function getByDeveloper(int $developerId): Collection
    {
        $this->permissionService->ensureIsAdminOrBackofficeUser();

        return Comment::where(Comment::USER_ID, $developerId)->with(['author'])->get();
    }

    public function getOne(int $commentId): Comment
    {
        $this->permissionService->ensureIsAdminOrBackofficeUser();

        return Comment::find($commentId)->with('author');
    }

    public function create(int $developerId, string $type, string $message): Comment
    {
        $this->permissionService->ensureIsAdminOrBackofficeUser();

        $comment = new Comment();
        $comment->{Comment::USER_ID} = $developerId;
        $comment->{Comment::AUTHOR_ID} = $this->getLoggedInUserId();
        $comment->{Comment::TYPE} = CommentType::get($type);
        $comment->{Comment::MESSAGE} = $message;
        $comment->saveOrFail();

        return $comment->with('author');
    }

    public function update(int $commentId, string $message): Comment
    {
        /** @var Comment $comment */
        $comment = Comment::find($commentId);
        $this->permissionService->ensureIsAdminOrUser($comment->{Comment::AUTHOR_ID});
        $comment->{Comment::MESSAGE} = $message;
        $comment->saveOrFail();

        return $comment->with('author');
    }

    public function delete(int $commentId): bool
    {
        $this->permissionService->ensureIsAdmin();

        /** @var Comment $comment */
        $comment = Comment::find($commentId);

        return $comment->delete();
    }

    private function getLoggedInUserId(): int
    {
        return Auth::user()->{User::ID};
    }
}
