<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Infrastructure\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Schema::defaultStringLength('191');
    }
}
