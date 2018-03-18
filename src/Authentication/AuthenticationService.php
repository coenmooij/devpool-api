<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

use Carbon\Carbon;
use CoenMooij\DevpoolApi\Developer\DeveloperServiceInterface;
use CoenMooij\DevpoolApi\Permission\PermissionServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

final class AuthenticationService implements AuthenticationServiceInterface
{
    private const GENERATED_PASSWORD_LENGTH = 23;

    /**
     * @var DeveloperServiceInterface
     */
    private $developerService;

    /**
     * @var PermissionServiceInterface
     */
    private $permissionService;

    public function __construct(DeveloperServiceInterface $developerService, PermissionServiceInterface $permissionService)
    {
        $this->developerService = $developerService;
        $this->permissionService = $permissionService;
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
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
            }
        }

        return $user;
    }

    public function registerAsDeveloper(string $email, string $firstName, string $lastName): User
    {
        $this->permissionService->ensureIsAdminOrBackofficeUser();
        $password = $this->generatePassword();
        $user = $this->register($email, $password, $firstName, $lastName, UserType::DEVELOPER);
        $this->developerService->createDeveloperFromUser($user);

        try {
            Mail::to($email)->send(new DeveloperBackofficeRegistrationMailer($user, $password));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
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

    private function generatePassword(): string
    {
        return random_bytes(self::GENERATED_PASSWORD_LENGTH);
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
