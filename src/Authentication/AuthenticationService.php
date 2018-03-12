<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

use Carbon\Carbon;
use CoenMooij\DevpoolApi\Developer\DeveloperServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

final class AuthenticationService implements AuthenticationServiceInterface
{
    /**
     * @var DeveloperServiceInterface
     */
    private $developerService;

    public function __construct(DeveloperServiceInterface $developerService)
    {
        $this->developerService = $developerService;
    }

    public function registerUser(
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        string $userType
    ): User {
        $user = $this->register($email, $password, $firstName, $lastName, $userType);

        if ($userType === UserType::DEVELOPER) {
            $this->developerService->createDeveloperFromUser($user);

            try {
                Mail::to($email)->send(new DeveloperRegistrationCompleteMailer($user));
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }

        return $user;
    }

    public function login(string $email, string $password): User
    {
        try {
            $user = $this->findUser(User::EMAIL, $email);
        } catch (ModelNotFoundException $exception) {
            throw new LoginFailedException();
        }

        if (!$this->passwordIsValid($password, $user->{User::SALT}, $user->{User::PASSWORD})) {
            throw new LoginFailedException();
        }

        $this->createToken($user);

        return $user;
    }

    public function logout(string $token): void
    {
        $user = $this->findUser(User::TOKEN, $token);
        $user->{User::TOKEN} = null;
        $user->{User::TOKEN_EXPIRES} = null;
        $user->saveOrFail();
    }

    public function resetPassword(string $email): void
    {
        Log::info('Password reset attempt for ' . $email);
    }

    private function register(
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        string $userType
    ): User {
        $user = new User();
        $user->{User::EMAIL} = $email;
        $user->{User::SALT} = $this->createSalt($user->{User::EMAIL});
        $user->{User::PASSWORD} = $this->hashPassword($password, $user->{User::SALT});
        $user->{User::FIRST_NAME} = $firstName;
        $user->{User::LAST_NAME} = $lastName;
        $user->{User::TYPE} = UserType::get($userType);
        $user->saveOrFail();

        return $user;
    }

    private function hashPassword(string $password, string $salt): string
    {
        return password_hash($password . $salt . $this->getPepper(), PASSWORD_BCRYPT);
    }

    private function passwordIsValid(string $password, string $salt, string $hash): bool
    {
        return password_verify($password . $salt . $this->getPepper(), $hash);
    }

    private function createSalt(string $prefix): string
    {
        return uniqid($prefix, true);
    }

    private function createToken(User $user): User
    {
        $token = $user->{User::ID} . bin2hex(random_bytes(64));
        $user->{User::TOKEN} = $token;
        $user->{User::TOKEN_EXPIRES} = Carbon::now()->addHours(1);
        $user->save();

        return $user;
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
