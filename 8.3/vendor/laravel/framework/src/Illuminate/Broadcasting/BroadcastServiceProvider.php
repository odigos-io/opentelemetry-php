<?php

namespace Odigos\Illuminate\Broadcasting;

use Odigos\Illuminate\Contracts\Broadcasting\Broadcaster as BroadcasterContract;
use Odigos\Illuminate\Contracts\Broadcasting\Factory as BroadcastingFactory;
use Odigos\Illuminate\Contracts\Support\DeferrableProvider;
use Odigos\Illuminate\Support\ServiceProvider;
class BroadcastServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BroadcastManager::class, fn($app) => new BroadcastManager($app));
        $this->app->singleton(BroadcasterContract::class, function ($app) {
            return $app->make(BroadcastManager::class)->connection();
        });
        $this->app->alias(BroadcastManager::class, BroadcastingFactory::class);
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [BroadcastManager::class, BroadcastingFactory::class, BroadcasterContract::class];
    }
}
