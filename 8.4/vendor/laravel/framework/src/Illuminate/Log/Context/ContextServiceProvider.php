<?php

namespace Illuminate\Log\Context;

use Illuminate\Contracts\Log\ContextLogProcessor as ContextLogProcessorContract;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Queue;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\ServiceProvider;
class ContextServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->scoped(\Illuminate\Log\Context\Repository::class);
        if ($this->app->runningInConsole()) {
            $this->app->resolving(\Illuminate\Log\Context\Repository::class, function (\Illuminate\Log\Context\Repository $repository) {
                $context = Env::get('__LARAVEL_CONTEXT');
                if ($context && $context = json_decode($context, associative: \true)) {
                    $repository->hydrate($context);
                }
            });
        }
        $this->app->bind(ContextLogProcessorContract::class, fn() => new \Illuminate\Log\Context\ContextLogProcessor());
    }
    /**
     * Boot the application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::createPayloadUsing(function ($connection, $queue, $payload) {
            /** @phpstan-ignore staticMethod.notFound */
            $context = Context::dehydrate();
            return $context === null ? $payload : [...$payload, 'illuminate:log:context' => $context];
        });
        $this->app['events']->listen(function (JobProcessing $event) {
            /** @phpstan-ignore staticMethod.notFound */
            Context::hydrate($event->job->payload()['illuminate:log:context'] ?? null);
        });
    }
}
