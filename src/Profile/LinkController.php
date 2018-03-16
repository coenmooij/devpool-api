<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use CoenMooij\DevpoolApi\Infrastructure\AbstractController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class LinkController extends AbstractController
{
    private const TYPE_KEY = 'type';
    private const VALUE_KEY = 'value';
    private const LINK_KEY = 'link';
    private const LINKS_KEY = 'links';
    private const MESSAGE_LINK_DELETED = 'Link was deleted';

    private const CREATE_RULES = [
        self::TYPE_KEY => 'required|max:255',
        self::VALUE_KEY => 'required|max:255',
    ];
    private const UPDATE_RULES = [
        self::VALUE_KEY => 'required|max:255',
    ];

    /**
     * @var LinkServiceInterface
     */
    private $linkService;

    public function __construct(LinkServiceInterface $linkService)
    {
        $this->linkService = $linkService;
    }

    public function getByDeveloper(int $id): JsonResponse
    {
        $links = $this->linkService->getByDeveloper($id);

        return self::createResponse(Response::HTTP_OK, [self::LINKS_KEY => $links]);
    }

    public function getOne(int $id): JsonResponse
    {
        $link = $this->linkService->getOne($id);

        return self::createResponse(Response::HTTP_OK, [self::LINK_KEY => $link]);
    }

    public function create(Request $request, int $id): JsonResponse
    {
        $this->validate($request, self::CREATE_RULES);
        $link = $this->linkService->create(
            $id,
            $request->request->get(self::TYPE_KEY),
            $request->request->get(self::VALUE_KEY)
        );

        return self::createResponse(Response::HTTP_CREATED, [self::LINK_KEY => $link]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, self::UPDATE_RULES);
        $link = $this->linkService->update($id, $request->request->get(self::VALUE_KEY));

        return self::createResponse(Response::HTTP_ACCEPTED, [self::LINK_KEY => $link]);
    }

    public function delete(int $id): JsonResponse
    {
        $this->linkService->delete($id);

        return self::createResponse(Response::HTTP_ACCEPTED, null, self::MESSAGE_LINK_DELETED);
    }
}
