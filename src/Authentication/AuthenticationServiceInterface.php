<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

interface AuthenticationServiceInterface
{
    public function registerUser(string $email, string $password, string $firstName, string $lastName, string $userType): User;

    public function login(string $email, string $password): User;

    public function logout(string $token): void;

    public function resetPassword(string $email): void;
}
