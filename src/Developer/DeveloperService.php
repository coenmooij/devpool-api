<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer;

use CoenMooij\DevpoolApi\Authentication\User;
use CoenMooij\DevpoolApi\Infrastructure\Exceptions\PermissionException;
use Illuminate\Database\Eloquent\Collection;

final class DeveloperService implements DeveloperServiceInterface
{
    private const BACKOFFICE_EXTRA_FIELDS = [
        'technologies',
        'links',
        'answers',
        'answers.question',
        'answers.question.form',
        'comments',
        'comments.author',
    ];

    private const DEVELOPER_EXTRA_FIELDS = [
        'technologies',
        'links',
        'answers',
        'answers.question',
        'answers.question.form',
    ];

    private const ORDER_DESCENDING = 'desc';

    /**
     * @return Developer[]|Collection
     * @throws PermissionException
     */
    public function getAllForUser(User $user): Collection
    {
        if ($user->isAdmin() || $user->isBackofficeUser()) {
            return Developer::with(['technologies'])->orderBy(Developer::PRIORITY, self::ORDER_DESCENDING)->get();
        }
        throw new PermissionException();
    }

    public function getOneForUser(User $user, int $id): Developer
    {
        if ($user->isAdmin() || $user->isBackofficeUser()) {
            return Developer::with(self::BACKOFFICE_EXTRA_FIELDS)->find($id);
        }
        if ($user->isDeveloper() && $user->{User::ID} === $id) {
            return Developer::with(self::DEVELOPER_EXTRA_FIELDS)->find($id);
        }
        throw new PermissionException();
    }

    public function createDeveloperFromUser(User $user): Developer
    {
        $developer = new Developer();
        $developer->{Developer::ID} = $user->{User::ID};

        $developer->saveOrFail();

        return $developer;
    }
}
