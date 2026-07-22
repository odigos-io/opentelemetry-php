<?php

namespace Odigos\Illuminate\Hashing;

use Odigos\Illuminate\Contracts\Support\DeferrableProvider;
use Odigos\Illuminate\Support\ServiceProvider;
class HashServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('hash', function ($app) {
            return new HashManager($app);
        });
        $this->app->singleton('hash.driver', function ($app) {
            return $app['hash']->driver();
        });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['hash', 'hash.driver'];
    }
}
