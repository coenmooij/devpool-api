<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer;

use CoenMooij\DevpoolApi\Authentication\User;
use CoenMooij\DevpoolApi\Infrastructure\Exceptions\PermissionException;
use Illuminate\Database\Eloquent\Collection;

final class DeveloperService implements DeveloperServiceInterface
{
    /**
     * @return Developer[]|Collection
     * @throws PermissionException
     */
    public function getAllForUser(User $user): Collection
    {
        if ($user->isAdmin() || $user->isBackofficeUser()) {
            return Developer::with(['technologies'])->get();
        }
        throw new PermissionException();
    }

    public function getOneForUser(User $user, int $id): Developer
    {
        if ($user->isAdmin() || $user->isBackofficeUser() || $user->{User::ID} === $id) {
            return Developer::with(
                [
                    'technologies',
                    'links',
                    'comments',
                    'answers',
                    'answers.question',
                    'answers.question.form',
                    'comments',
                    'comments.author',
                ]
            )->find($id);
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
