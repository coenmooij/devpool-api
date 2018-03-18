<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

use CoenMooij\DevpoolApi\Infrastructure\AbstractController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class AuthenticationController extends AbstractController
{
    private const LOGIN_SUCCESS = 'Login successful';
    private const LOGOUT_SUCCESS = 'Logout successful';
    private const PASSWORD_RESET = 'Password reset link was sent';
    private const REGISTER_DEVELOPER_SUCCESS = 'Developer registration successful';

    private const EMAIL_KEY = 'email';
    private const PASSWORD_KEY = 'password';
    private const FIRST_NAME_KEY = 'first_name';
    private const LAST_NAME_KEY = 'last_name';

    private const LOGIN_VALIDATION_RULES = [
        self::EMAIL_KEY => 'required|email|max:255',
        self::PASSWORD_KEY => 'required|max:255',
    ];
    private const REGISTER_VALIDATION_RULES = [
        self::EMAIL_KEY => 'required|email|max:255',
        self::PASSWORD_KEY => 'required|max:255',
        self::FIRST_NAME_KEY => 'required|max:255',
        self::LAST_NAME_KEY => 'required|max:255',
    ];
    private const REGISTER_AS_VALIDATION_RULES = [
        self::EMAIL_KEY => 'required|email|max:255',
        self::FIRST_NAME_KEY => 'required|max:255',
        self::LAST_NAME_KEY => 'required|max:255',
    ];
    private const RESET_PASSWORD_VALIDATION_RULES = [
        self::EMAIL_KEY => 'required|email|max:255',
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
        $this->validate($request, self::REGISTER_VALIDATION_RULES);

        $user = $this->authenticationService->registerUser(
            $request->request->get(self::EMAIL_KEY),
            $request->request->get(self::PASSWORD_KEY),
            $request->request->get(self::FIRST_NAME_KEY),
            $request->request->get(self::LAST_NAME_KEY),
            UserType::DEVELOPER
        );

        return self::createResponse(
            Response::HTTP_CREATED,
            ['user' => $user],
            self::REGISTER_DEVELOPER_SUCCESS
        );
    }

    public function registerAsDeveloper(Request $request): JsonResponse
    {
        $this->validate($request, self::REGISTER_AS_VALIDATION_RULES);

        $user = $this->authenticationService->registerAsDeveloper(
            $request->request->get(self::EMAIL_KEY),
            $request->request->get(self::FIRST_NAME_KEY),
            $request->request->get(self::LAST_NAME_KEY)
        );

        return self::createResponse(
            Response::HTTP_CREATED,
            ['user' => $user],
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
            ['token' => $user->{User::TOKEN}, 'type' => $user->getType()],
            self::LOGIN_SUCCESS
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authenticationService->logout($request->header('token', ''));

        return self::createResponse(Response::HTTP_OK, null, self::LOGOUT_SUCCESS);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $this->validate($request, self::RESET_PASSWORD_VALIDATION_RULES);

        $this->authenticationService->resetPassword($request->request->get('email'));

        return self::createResponse(Response::HTTP_CREATED, null, self::PASSWORD_RESET);
    }
}
