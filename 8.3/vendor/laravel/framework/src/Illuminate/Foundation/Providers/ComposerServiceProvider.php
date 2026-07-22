<?php

namespace Odigos\Illuminate\Foundation\Providers;

use Odigos\Illuminate\Contracts\Support\DeferrableProvider;
use Odigos\Illuminate\Support\Composer;
use Odigos\Illuminate\Support\ServiceProvider;
class ComposerServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('composer', function ($app) {
            return new Composer($app['files'], $app->basePath());
        });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['composer'];
    }
}
