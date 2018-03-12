<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer;

use CoenMooij\DevpoolApi\Authentication\User;
use Illuminate\Database\Eloquent\Collection;

final class DeveloperService implements DeveloperServiceInterface
{
    /**
     * @return Developer[]|Collection
     */
    public function getAll(): Collection
    {
        // Todo: Check permissions
        return Developer::with(['technologies'])->get();
    }

    public function getOne(int $id): Developer
    {
        // Todo: Check permissions
        return Developer::with(['technologies', 'links', 'comments', 'answers'])->find($id);
    }

    public function createDeveloperFromUser(User $user): Developer
    {
        $developer = new Developer();
        $developer->{Developer::ID} = $user->{User::ID};

        $developer->saveOrFail();

        return $developer;
    }
}
