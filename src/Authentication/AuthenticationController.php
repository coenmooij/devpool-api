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

        $id = $this->authenticationService->register(
            $request->request->get(self::EMAIL_KEY),
            $request->request->get(self::PASSWORD_KEY),
            $request->request->get(self::FIRST_NAME_KEY),
            $request->request->get(self::LAST_NAME_KEY),
            User::TYPE_DEVELOPER
        );

        return self::createResponse(
            ['message' => self::REGISTER_DEVELOPER_SUCCESS, 'id' => $id],
            Response::HTTP_CREATED
        );
    }

    public function login(Request $request): JsonResponse
    {
        $this->validate($request, self::LOGIN_VALIDATION_RULES);
        $token = $this->authenticationService->login(
            $request->request->get(self::EMAIL_KEY),
            $request->request->get(self::PASSWORD_KEY)
        );

        return self::createResponse(['message' => self::LOGIN_SUCCESS, 'token' => $token], Response::HTTP_CREATED);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authenticationService->logout($request->header('token', ''));

        return self::createResponse(['message' => self::LOGOUT_SUCCESS], Response::HTTP_OK);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $this->validate($request, self::RESET_PASSWORD_VALIDATION_RULES);

        $this->authenticationService->resetPassword($request->request->get('email'));

        return self::createResponse(['message' => self::PASSWORD_RESET], 201);
    }
}
