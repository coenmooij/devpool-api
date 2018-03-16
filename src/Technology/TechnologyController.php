<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

use CoenMooij\DevpoolApi\Infrastructure\AbstractController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class TechnologyController extends AbstractController
{
    private const TECHNOLOGIES_KEY = 'technologies';
    private const TECHNOLOGY_ID_LIST_KEY = 'technology_id_list';

    /**
     * @var TechnologyServiceInterface
     */
    private $technologyService;

    public function __construct(TechnologyServiceInterface $technologyService)
    {
        $this->technologyService = $technologyService;
    }

    public function getByDeveloper(int $id): JsonResponse
    {
        $technologies = $this->technologyService->getByDeveloper($id);

        return self::createResponse(Response::HTTP_OK, [self::TECHNOLOGIES_KEY => $technologies]);
    }

    public function addToDeveloper(Request $request, int $id): JsonResponse
    {
        $technologies = $this->technologyService->addToDeveloper(
            $id,
            $request->request->get(self::TECHNOLOGY_ID_LIST_KEY)
        );

        return self::createResponse(Response::HTTP_OK, [self::TECHNOLOGIES_KEY => $technologies]);
    }

    public function removeFromDeveloper(Request $request, int $id): JsonResponse
    {
        $technologies = $this->technologyService->removeFromDeveloper(
            $id,
            $request->request->get(self::TECHNOLOGY_ID_LIST_KEY)
        );

        return self::createResponse(Response::HTTP_OK, [self::TECHNOLOGIES_KEY => $technologies]);
    }
}
