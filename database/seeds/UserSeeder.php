<?php

use CoenMooij\DevpoolApi\Authentication\AuthenticationServiceInterface;
use CoenMooij\DevpoolApi\Authentication\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private const DEFAULT_PASSWORD = '123456';
    private const DEVELOPERS = [
        ['Coen', 'Mooij', 'coenmooij@gmail.com'],
        ['Kevin', 'Barasa', 'kevin.barasa001@gmail.com'],
        ['Coen', 'Mooij', 'coen.mooij@casparcoding.com'],
        ['Kevin', 'Barasa', 'kevin.barasa@casparcoding.com'],
    ];
    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function run(): void
    {
        $this->registerDevelopers(self::DEVELOPERS);
    }

    private function registerDevelopers($developers): void
    {
        foreach ($developers as $developer) {
            $this->registerDeveloper(...$developer);
        }
    }

    private function registerDeveloper(string $firstName, string $lastName, string $email): void
    {
        if ($this->getUserByEmail($email) === null) {
            $this->authenticationService->registerDeveloper($email, self::DEFAULT_PASSWORD, $firstName, $lastName);
        }
    }

    private function getUserByEmail(string $email): ?User
    {
        return User::where(User::EMAIL, $email)->first();
    }
}
