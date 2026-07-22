<?php

namespace Odigos\Illuminate\Testing;

use Odigos\Illuminate\Contracts\Support\DeferrableProvider;
use Odigos\Illuminate\Support\ServiceProvider;
use Odigos\Illuminate\Testing\Concerns\TestCaches;
use Odigos\Illuminate\Testing\Concerns\TestDatabases;
use Odigos\Illuminate\Testing\Concerns\TestViews;
class ParallelTestingServiceProvider extends ServiceProvider implements DeferrableProvider
{
    use TestCaches, TestDatabases, TestViews;
    /**
     * Boot the application's service providers.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootTestCache();
            $this->bootTestDatabase();
            $this->bootTestViews();
        }
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->app->singleton(ParallelTesting::class, function () {
                return new ParallelTesting($this->app);
            });
        }
    }
}
