<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Profile;

use CoenMooij\DevpoolApi\Infrastructure\AbstractController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkController extends AbstractController
{
    /**
     * @var LinkServiceInterface
     */
    private $linkService;

    public function __construct(LinkServiceInterface $linkService)
    {
        $this->linkService = $linkService;
    }
    public function get(Request $request): JsonResponse
    {

    }
}
