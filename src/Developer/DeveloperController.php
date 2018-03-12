<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer;

use CoenMooij\DevpoolApi\Infrastructure\AbstractController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeveloperController extends AbstractController
{
    /**
     * @var DeveloperServiceInterface
     */
    private $developerService;

    public function __construct(DeveloperServiceInterface $developerService)
    {
        $this->developerService = $developerService;
    }

    public function getAll(Request $request): JsonResponse
    {
        // Todo: validate filter by, sort/order
        $developers = $this->developerService->getAll();

        return self::createResponse(
            Response::HTTP_OK,
            ['developers' => $developers]
        );
    }

    public function getOne(int $id): JsonResponse
    {
        $developer = $this->developerService->getOne($id);

        return self::createResponse(
            Response::HTTP_OK,
            ['developer' => $developer]
        );
    }
}
