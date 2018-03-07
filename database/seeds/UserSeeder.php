<?php

use CoenMooij\DevpoolApi\Authentication\AuthenticationServiceInterface;
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
        $this->authenticationService->register('coenmooij@gmail.com', 'test');
    }
}
