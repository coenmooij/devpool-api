<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

interface AuthenticationServiceInterface
{
    public function register(string $email, string $password): int;

    public function login(string $email, string $password): string;

    public function logout(string $token): void;

    public function resetPassword(string $email): void;
}
