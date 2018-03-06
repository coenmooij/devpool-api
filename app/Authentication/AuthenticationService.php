<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class AuthenticationService implements AuthenticationServiceInterface
{
    public function login(string $email, string $password): string
    {
        try {
            $user = $this->findUser(User::EMAIL, $email);
        } catch (ModelNotFoundException $exception) {
            throw new LoginFailedException('User not found');
        }

        if (!$this->passwordIsValid($password, $user->{User::SALT}, $user->{User::PASSWORD})) {
            throw new LoginFailedException('Password mismatch');
        }

        return $this->createToken($user);
    }

    public function logout(string $token): void
    {
        $user = $this->authenticate($token);
        $user->{User::TOKEN} = null;
        $user->{User::TOKEN_EXPIRES} = null;
        $user->saveOrFail();
    }

    public function register(string $email, string $password):string
    {
        $user = new User();
        $user->{User::EMAIL} = $email;
        $user->{User::SALT} = $this->createSalt($user->{User::EMAIL});
        $user->{User::PASSWORD} = $this->hashPassword($password, $user->{User::SALT});
        $user->{User::TOKEN_EXPIRES} = Carbon::now()->addHour();
        $user->saveOrFail();

        return $user->{User::ID};
    }

    public function resetPassword(string $email): void
    {
        // TODO: Implement resetPassword() method.
    }

    public function authenticate($token): User
    {
        return $this->findUser(User::TOKEN, $token);
    }

    private function hashPassword(string $password, string $salt): string
    {
        return password_hash($password . $salt . $this->getPepper(), PASSWORD_BCRYPT);
    }

    private function passwordIsValid($password, $salt, $hash): bool
    {
        return password_verify($password . $salt . $this->getPepper(), $hash);
    }

    private function createSalt(string $prefix): string
    {
        return uniqid($prefix, true);
    }

    private function createToken(User $user)
    {
        $token = $user->{User::ID} . bin2hex(random_bytes(64));
        $user->{User::TOKEN} = $token;
        $user->{User::TOKEN_EXPIRES} = Carbon::now()->addHours(1);
        $user->save();

        return $token;
    }

    private function findUser($column, $value): User
    {
        return User::where($column, $value)->firstOrFail();
    }

    private function getPepper(): string
    {
        return env('PEPPER', '');
    }
}
