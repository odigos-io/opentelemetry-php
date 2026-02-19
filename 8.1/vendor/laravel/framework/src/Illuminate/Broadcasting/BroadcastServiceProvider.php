<?php

namespace Illuminate\Broadcasting;

use Illuminate\Contracts\Broadcasting\Broadcaster as BroadcasterContract;
use Illuminate\Contracts\Broadcasting\Factory as BroadcastingFactory;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
class BroadcastServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Illuminate\Broadcasting\BroadcastManager::class, fn($app) => new \Illuminate\Broadcasting\BroadcastManager($app));
        $this->app->singleton(BroadcasterContract::class, function ($app) {
            return $app->make(\Illuminate\Broadcasting\BroadcastManager::class)->connection();
        });
        $this->app->alias(\Illuminate\Broadcasting\BroadcastManager::class, BroadcastingFactory::class);
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [\Illuminate\Broadcasting\BroadcastManager::class, BroadcastingFactory::class, BroadcasterContract::class];
    }
}
