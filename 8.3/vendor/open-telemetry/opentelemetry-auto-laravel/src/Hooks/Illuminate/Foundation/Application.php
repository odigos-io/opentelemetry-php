<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\Illuminate\Foundation;

use Odigos\Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Odigos\Illuminate\Foundation\Application as FoundationalApplication;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\LaravelHook;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\LaravelHookTrait;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Watchers\CacheWatcher;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Watchers\ClientRequestWatcher;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Watchers\ExceptionWatcher;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Watchers\LogWatcher;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Watchers\QueryWatcher;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Watchers\RedisCommand\RedisCommandWatcher;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Watchers\Watcher;
use function OpenTelemetry\Instrumentation\hook;
use Throwable;
class Application implements LaravelHook
{
    use LaravelHookTrait;
    public function instrument(): void
    {
        /** @psalm-suppress UnusedFunctionCall */
        hook('Illuminate\\Foundation\\Application', '__construct', post: function (object $application, array $_params, mixed $_returnValue, ?Throwable $_exception) {
            $this->registerWatchers($application, new CacheWatcher());
            $this->registerWatchers($application, new ClientRequestWatcher($this->instrumentation));
            $this->registerWatchers($application, new ExceptionWatcher());
            $this->registerWatchers($application, new LogWatcher($this->instrumentation));
            $this->registerWatchers($application, new QueryWatcher($this->instrumentation));
            $this->registerWatchers($application, new RedisCommandWatcher($this->instrumentation));
        });
    }
    private function registerWatchers(object $app, Watcher $watcher): void
    {
        $watcher->register($app);
    }
}
