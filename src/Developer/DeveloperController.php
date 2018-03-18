<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer;

use CoenMooij\DevpoolApi\Infrastructure\AbstractController;
use CoenMooij\DevpoolApi\Profile\PipelineStatus;
use CoenMooij\DevpoolApi\Profile\Seniority;
use CoenMooij\DevpoolApi\Profile\Speciality;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

final class DeveloperController extends AbstractController
{
    private const MESSAGE_DEVELOPER_UPDATED = 'Successfully updated developer';
    private const DEVELOPER_KEY = 'developer';
    private const DEVELOPERS_KEY = 'developers';

    private const SPECIALITY_KEY = 'speciality';
    private const SENIORITY_KEY = 'seniority';
    private const PIPELINE_STATUS_KEY = 'pipeline_status';
    private const COUNTRY_KEY = 'country';
    private const PHONE_KEY = 'phone';
    private const BIRTH_DATE_KEY = 'birth_date';
    private const SALARY_KEY = 'birth_date';

    private const UPDATE_RULES = [
        self::SPECIALITY_KEY => 'max:255',
        self::SENIORITY_KEY => 'max:255',
        self::PIPELINE_STATUS_KEY => 'max:255',
        self::COUNTRY_KEY => 'max:255',
        self::PHONE_KEY => 'max:255',
        self::BIRTH_DATE_KEY => 'date',
        self::SALARY_KEY => 'max:255',
    ];

    /**
     * @var DeveloperServiceInterface
     */
    private $developerService;

    public function __construct(DeveloperServiceInterface $developerService)
    {
        $this->developerService = $developerService;
    }

    public function getAll(): JsonResponse
    {
        // TODO : Add filters, orderBy
        $developers = $this->developerService->getAll();

        return self::createResponse(
            Response::HTTP_OK,
            [self::DEVELOPERS_KEY => $developers]
        );
    }

    public function getOne(int $id): JsonResponse
    {
        $developer = $this->developerService->getOne($id);

        return self::createResponse(
            Response::HTTP_OK,
            [self::DEVELOPER_KEY => $developer]
        );
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, self::UPDATE_RULES);
        $this->validate(
            $request,
            [
                self::SPECIALITY_KEY => [Rule::in(array_keys(Speciality::getAllNames()))],
                self::SENIORITY_KEY => [Rule::in(array_keys(Seniority::getAllNames()))],
                self::PIPELINE_STATUS_KEY => [Rule::in(array_keys(PipelineStatus::getAllNames()))],
            ]
        );
        $updateFields = array_filter(
            $request->keys(),
            function ($key) {
                return in_array($key, array_keys(self::UPDATE_RULES));
            }
        );
        $developer = $this->developerService->update($id, $request->all($updateFields));

        return self::createResponse(
            Response::HTTP_ACCEPTED,
            [self::DEVELOPER_KEY => $developer],
            self::MESSAGE_DEVELOPER_UPDATED
        );
    }
}
