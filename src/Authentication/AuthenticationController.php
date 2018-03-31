<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

use CoenMooij\DevpoolApi\Infrastructure\AbstractController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

final class AuthenticationController extends AbstractController
{
    private const LOGIN_SUCCESS = 'Login successful';
    private const LOGOUT_SUCCESS = 'Logout successful';
    private const PASSWORD_RESET = 'Password reset link was sent';
    private const REGISTER_DEVELOPER_SUCCESS = 'Developer registration successful';
    private const USER_UPDATED = 'user successfully updated';

    private const EMAIL_KEY = 'email';
    private const PASSWORD_KEY = 'password';
    private const FIRST_NAME_KEY = 'first_name';
    private const LAST_NAME_KEY = 'last_name';
    private const NICKNAME_KEY = 'nickname';
    private const SHOW_NICKNAME_KEY = 'show_nickname';
    private const USER_RESPONSE_KEY = 'user';
    private const TOKEN_KEY = 'token';

    private const LOGIN_VALIDATION_RULES = [
        self::EMAIL_KEY => 'required|email|max:255',
        self::PASSWORD_KEY => 'required|max:255',
    ];
    private const REGISTER_RULES = [
        self::EMAIL_KEY => 'required|email|max:255',
        self::PASSWORD_KEY => 'required|max:255',
        self::FIRST_NAME_KEY => 'required|max:255',
        self::LAST_NAME_KEY => 'required|max:255',
    ];
    private const REGISTER_AS_RULES = [
        self::EMAIL_KEY => 'required|email|max:255',
        self::FIRST_NAME_KEY => 'required|max:255',
        self::LAST_NAME_KEY => 'required|max:255',
    ];
    private const RESET_PASSWORD_RULES = [
        self::EMAIL_KEY => 'required|email|max:255',
    ];
    private const UPDATE_RULES = [
        self::FIRST_NAME_KEY => 'max:255',
        self::LAST_NAME_KEY => 'max:255',
        self::NICKNAME_KEY => 'max:255',
        self::SHOW_NICKNAME_KEY => 'boolean',
    ];

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function registerDeveloper(Request $request): JsonResponse
    {
        $this->validate($request, self::REGISTER_RULES);

        $user = $this->authenticationService->registerUser(
            $request->request->get(self::EMAIL_KEY),
            $request->request->get(self::PASSWORD_KEY),
            $request->request->get(self::FIRST_NAME_KEY),
            $request->request->get(self::LAST_NAME_KEY),
            UserType::DEVELOPER
        );

        return self::createResponse(
            Response::HTTP_CREATED,
            [self::USER_RESPONSE_KEY => $user],
            self::REGISTER_DEVELOPER_SUCCESS
        );
    }

    public function registerAsDeveloper(Request $request): JsonResponse
    {
        $this->validate($request, self::REGISTER_AS_RULES);

        $user = $this->authenticationService->registerAsDeveloper(
            $request->request->get(self::EMAIL_KEY),
            $request->request->get(self::FIRST_NAME_KEY),
            $request->request->get(self::LAST_NAME_KEY)
        );

        return self::createResponse(
            Response::HTTP_CREATED,
            [self::USER_RESPONSE_KEY => $user],
            self::REGISTER_DEVELOPER_SUCCESS
        );
    }

    public function login(Request $request): JsonResponse
    {
        $this->validate($request, self::LOGIN_VALIDATION_RULES);
        $user = $this->authenticationService->login(
            $request->request->get(self::EMAIL_KEY),
            $request->request->get(self::PASSWORD_KEY)
        );

        return self::createResponse(
            Response::HTTP_CREATED,
            [self::TOKEN_KEY => $user->{User::TOKEN}, 'type' => $user->{User::TYPE}],
            self::LOGIN_SUCCESS
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authenticationService->logout($request->header(self::TOKEN_KEY, ''));

        return self::createResponse(Response::HTTP_OK, null, self::LOGOUT_SUCCESS);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, self::UPDATE_RULES);

        $updatedFields = array_filter(
            $request->keys(),
            function ($key) {
                return in_array($key, array_keys(self::UPDATE_RULES));
            }
        );
        $user = $this->authenticationService->update($id, $request->all($updatedFields));

        return self::createResponse(Response::HTTP_ACCEPTED, [self::USER_RESPONSE_KEY => $user], self::USER_UPDATED);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $this->validate($request, self::RESET_PASSWORD_RULES);

        $this->authenticationService->resetPassword($request->request->get(self::EMAIL_KEY));

        return self::createResponse(Response::HTTP_CREATED, null, self::PASSWORD_RESET);
    }
}
