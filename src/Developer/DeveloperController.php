<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Developer;

use CoenMooij\DevpoolApi\Authentication\AuthenticationServiceInterface;
use CoenMooij\DevpoolApi\Infrastructure\AbstractController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeveloperController extends AbstractController
{
    private const SENIORITY = ['trainee', 'junior', 'medior', 'senior', 'lead', 'architect'];
    private const SPECIALISATION = ['fullstack', 'frontend', 'backend', 'devops', 'mobile'];
    private const STATUSES = ['code review', 'technical interview', 'caspar', 'code missing'];

    public function getAll(): JsonResponse
    {
        $developerDataStub = [
            $this->createDeveloperData('Kevin', 'Barasa', ['PHP', 'Javascript'], ['Laravel', 'Vue'], 0),
            $this->createDeveloperData('Vincent', 'Wijdeveld', ['C#', 'Java'], ['.NET', 'Spring'], 1),
            $this->createDeveloperData('Sebastiaan', 'Tan', ['Javascript'], ['React-native'], 2),
            $this->createDeveloperData('Coen', 'Mooij', ['PHP', 'Javascript'], ['Laravel'], 3),
            $this->createDeveloperData('Derk', 'van der Grijp', ['Objective-C', 'Python'], ['Django'], 4),
            $this->createDeveloperData('Abigail', 'Muruchi', ['Swift'], [], 5),
        ];

        return self::createResponse($developerDataStub, Response::HTTP_OK);
    }

    private function createDeveloperData(
        string $firstName,
        string $lastName,
        array $programmingLanguages,
        array $frameworks,
        int $id
    ): array {
        return [
            'id' => $id,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'specialisation' => self::SPECIALISATION[random_int(0, count(self::SPECIALISATION) - 1)],
            'seniority' => self::SENIORITY[random_int(0, count(self::SENIORITY) - 1)],
            'programmingLanguages' => $programmingLanguages,
            'frameworks' => $frameworks,
            'currentSalary' => random_int(500, 5000),
            'status' => self::STATUSES[random_int(0, count(self::STATUSES) - 1)],
        ];
    }
}
