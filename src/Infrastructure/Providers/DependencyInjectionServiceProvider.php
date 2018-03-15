<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Infrastructure\Providers;

use CoenMooij\DevpoolApi\Authentication\AuthenticationService;
use CoenMooij\DevpoolApi\Authentication\AuthenticationServiceInterface;
use CoenMooij\DevpoolApi\Developer\DeveloperService;
use CoenMooij\DevpoolApi\Developer\DeveloperServiceInterface;
use CoenMooij\DevpoolApi\Profile\LinkService;
use CoenMooij\DevpoolApi\Profile\LinkServiceInterface;
use Illuminate\Support\ServiceProvider;

class DependencyInjectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthenticationServiceInterface::class, AuthenticationService::class);
        $this->app->bind(DeveloperServiceInterface::class, DeveloperService::class);
        $this->app->bind(LinkServiceInterface::class, LinkService::class);
    }
}
