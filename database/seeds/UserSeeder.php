<?php

use CoenMooij\DevpoolApi\Authentication\AuthenticationServiceInterface;
use CoenMooij\DevpoolApi\Authentication\User;
use CoenMooij\DevpoolApi\Authentication\UserType;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    private const DEFAULT_PASSWORD = '123456';
    private const USERS = [
        ['Sally', 'Sellers', 'sales@casparcoding.com', UserType::BACKOFFICE],
        ['Clayant', 'von Klientface', 'client@casparcoding.com', UserType::CLIENT],
        ['Ed', 'Min', 'admin@casparcoding.com', UserType::ADMIN],
        ['Inta', 'Viwa', 'interview@casparcoding.com', UserType::BACKOFFICE],
        ['Koda', 'Viwa', 'code@casparcoding.com', UserType::BACKOFFICE],
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
        $this->registerUsers(self::USERS);
    }

    private function registerUsers($users): void
    {
        foreach ($users as $user) {
            $this->registerUser(...$user);
        }
    }

    private function registerUser(string $firstName, string $lastName, string $email, string $userType): void
    {
        if ($this->getUserByEmail($email) === null) {
            $this->authenticationService->registerUser($email, self::DEFAULT_PASSWORD, $firstName, $lastName, $userType);
        }
    }

    private function getUserByEmail(string $email): ?User
    {
        return User::where(User::EMAIL, $email)->first();
    }
}
