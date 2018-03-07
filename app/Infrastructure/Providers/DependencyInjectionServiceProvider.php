<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Infrastructure\Providers;

use CoenMooij\DevpoolApi\Authentication\AuthenticationService;
use CoenMooij\DevpoolApi\Authentication\AuthenticationServiceInterface;
use Illuminate\Support\ServiceProvider;

class DependencyInjectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthenticationServiceInterface::class, AuthenticationService::class);
    }

}
