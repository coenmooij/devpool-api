<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use CoenMooij\DevpoolApi\Permission\PermissionServiceInterface;
use Illuminate\Database\Eloquent\Collection;

final class LinkService implements LinkServiceInterface
{
    /**
     * @var PermissionServiceInterface
     */
    private $permissionService;

    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @return Link[]|Collection
     */
    public function getByDeveloper(int $developerId): Collection
    {
        $this->permissionService->ensureCanAccessDeveloper($developerId);

        return Link::where(Link::USER_ID, $developerId)->get();
    }

    /**
     * @return Link[]|Collection
     */
    public function getByType(string $type): Collection
    {
        $this->permissionService->ensureIsAdmin();

        return Link::where(Link::TYPE, $type)->get();
    }

    public function getOne(int $linkId): Link
    {
        /** @var Link $link */
        $link = Link::findOrFail($linkId);
        $this->permissionService->ensureCanAccessDeveloper($link->{Link::USER_ID});

        return $link;
    }

    public function create(int $developerId, string $type, string $value): Link
    {
        $this->permissionService->ensureCanAccessDeveloper($developerId);

        $link = new Link();
        $link->{Link::USER_ID} = $developerId;
        $link->{Link::TYPE} = LinkType::get($type);
        $link->{Link::VALUE} = $value;
        $link->saveOrFail();

        return $link;
    }

    public function update(int $linkId, string $value): Link
    {
        /** @var Link $link */
        $link = Link::findOrFail($linkId);
        $this->permissionService->ensureCanAccessDeveloper($link->{Link::USER_ID});
        $link->{Link::VALUE} = $value;
        $link->saveOrFail();

        return $link;
    }

    public function delete(int $linkId): bool
    {
        /** @var Link $link */
        $link = Link::findOrFail($linkId);
        $this->permissionService->ensureCanAccessDeveloper($link->{Link::USER_ID});

        return $link->delete();
    }
}
