<?php

namespace Flooris\XelionClient;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class XelionServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(XelionService::class, function ($app) {
            return new XelionService();
        });
    }

    public function provides(): array
    {
        return [XelionService::class];
    }
}
