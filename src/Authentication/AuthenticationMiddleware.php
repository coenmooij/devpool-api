<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Authentication;

use Carbon\Carbon;
use Closure;
use CoenMooij\DevpoolApi\Infrastructure\AbstractController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class AuthenticationMiddleware
{
    const TOKEN_INVALID = 'Invalid Token';

    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('token', '');
        if ($this->tokenIsValid($request, $token)) {
            return $next($request);
        }

        return AbstractController::createResponse(Response::HTTP_UNAUTHORIZED, null, self::TOKEN_INVALID);
    }

    private function tokenIsValid(Request $request, string $token): bool
    {
        try {
            $user = User::where('token', $token)
                ->where('token_expires', '>', Carbon::now())
                ->select([User::ID, User::EMAIL, User::FIRST_NAME, User::LAST_NAME])
                ->firstOrFail();
            $user->{User::TOKEN_EXPIRES} = Carbon::now()->addHours(1);
            $user->save();
            $request->attributes->set('user', $user);

            return true;
        } catch (ModelNotFoundException $exception) {
            return false;
        }
    }
}
