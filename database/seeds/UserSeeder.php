<?php

use CoenMooij\DevpoolApi\Authentication\AuthenticationServiceInterface;
use CoenMooij\DevpoolApi\Authentication\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
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
        if (User::all()->count() === 0) {
            $this->authenticationService->registerDeveloper(
                'coenmooij@gmail.com',
                '123456',
                'Coen',
                'Mooij'
            );
        }
    }
}
