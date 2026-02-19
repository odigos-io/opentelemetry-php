<?php

namespace Illuminate\Bus;

use Odigos\Aws\DynamoDb\DynamoDbClient;
use Illuminate\Contracts\Bus\Dispatcher as DispatcherContract;
use Illuminate\Contracts\Bus\QueueingDispatcher as QueueingDispatcherContract;
use Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
class BusServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Illuminate\Bus\Dispatcher::class, function ($app) {
            return new \Illuminate\Bus\Dispatcher($app, function ($connection = null) use ($app) {
                return $app[QueueFactoryContract::class]->connection($connection);
            });
        });
        $this->registerBatchServices();
        $this->app->alias(\Illuminate\Bus\Dispatcher::class, DispatcherContract::class);
        $this->app->alias(\Illuminate\Bus\Dispatcher::class, QueueingDispatcherContract::class);
    }
    /**
     * Register the batch handling services.
     *
     * @return void
     */
    protected function registerBatchServices()
    {
        $this->app->singleton(\Illuminate\Bus\BatchRepository::class, function ($app) {
            $driver = $app->config->get('queue.batching.driver', 'database');
            return $driver === 'dynamodb' ? $app->make(\Illuminate\Bus\DynamoBatchRepository::class) : $app->make(\Illuminate\Bus\DatabaseBatchRepository::class);
        });
        $this->app->singleton(\Illuminate\Bus\DatabaseBatchRepository::class, function ($app) {
            return new \Illuminate\Bus\DatabaseBatchRepository($app->make(\Illuminate\Bus\BatchFactory::class), $app->make('db')->connection($app->config->get('queue.batching.database')), $app->config->get('queue.batching.table', 'job_batches'));
        });
        $this->app->singleton(\Illuminate\Bus\DynamoBatchRepository::class, function ($app) {
            $config = $app->config->get('queue.batching');
            $dynamoConfig = ['region' => $config['region'], 'version' => 'latest', 'endpoint' => $config['endpoint'] ?? null];
            if (!empty($config['key']) && !empty($config['secret'])) {
                $dynamoConfig['credentials'] = Arr::only($config, ['key', 'secret', 'token']);
            }
            return new \Illuminate\Bus\DynamoBatchRepository($app->make(\Illuminate\Bus\BatchFactory::class), new DynamoDbClient($dynamoConfig), $app->config->get('app.name'), $app->config->get('queue.batching.table', 'job_batches'), ttl: $app->config->get('queue.batching.ttl', null), ttlAttribute: $app->config->get('queue.batching.ttl_attribute', 'ttl'));
        });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [\Illuminate\Bus\Dispatcher::class, DispatcherContract::class, QueueingDispatcherContract::class, \Illuminate\Bus\BatchRepository::class, \Illuminate\Bus\DatabaseBatchRepository::class];
    }
}
