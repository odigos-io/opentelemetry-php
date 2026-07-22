<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Watchers;

use Odigos\Illuminate\Cache\Events\CacheHit;
use Odigos\Illuminate\Cache\Events\CacheMissed;
use Odigos\Illuminate\Cache\Events\KeyForgotten;
use Odigos\Illuminate\Cache\Events\KeyWritten;
use Odigos\Illuminate\Contracts\Foundation\Application;
use OpenTelemetry\API\Trace\Span;
use OpenTelemetry\Context\Context;
class CacheWatcher extends Watcher
{
    /**
     * @psalm-suppress UndefinedInterfaceMethod
     * @suppress PhanTypeArraySuspicious
     */
    public function register(object $app): void
    {
        $app['events']->listen(CacheHit::class, [$this, 'recordCacheHit']);
        $app['events']->listen(CacheMissed::class, [$this, 'recordCacheMiss']);
        $app['events']->listen(KeyWritten::class, [$this, 'recordCacheSet']);
        $app['events']->listen(KeyForgotten::class, [$this, 'recordCacheForget']);
    }
    /** @psalm-suppress PossiblyUnusedMethod */
    public function recordCacheHit(object $event): void
    {
        $this->addEvent('cache hit', ['key' => $event->key, 'tags' => json_encode($event->tags)]);
    }
    /** @psalm-suppress PossiblyUnusedMethod */
    public function recordCacheMiss(object $event): void
    {
        $this->addEvent('cache miss', ['key' => $event->key, 'tags' => json_encode($event->tags)]);
    }
    /**
     * @psalm-suppress UndefinedPropertyFetch
     * @psalm-suppress PossiblyUnusedMethod
     * @suppress PhanUndeclaredProperty
     */
    public function recordCacheSet(object $event): void
    {
        $ttl = property_exists($event, 'minutes') ? $event->minutes * 60 : $event->seconds;
        $this->addEvent('cache set', ['key' => $event->key, 'tags' => json_encode($event->tags), 'expires_at' => $ttl > 0 ? now()->addSeconds($ttl)->getTimestamp() : 'never', 'expires_in_seconds' => $ttl > 0 ? $ttl : 'never', 'expires_in_human' => $ttl > 0 ? now()->addSeconds($ttl)->diffForHumans() : 'never']);
    }
    /** @psalm-suppress PossiblyUnusedMethod */
    public function recordCacheForget(object $event): void
    {
        $this->addEvent('cache forget', ['key' => $event->key, 'tags' => json_encode($event->tags)]);
    }
    private function addEvent(string $name, iterable $attributes = []): void
    {
        $scope = Context::storage()->scope();
        if (!$scope) {
            return;
        }
        $span = Span::fromContext($scope->context());
        $span->addEvent($name, $attributes);
    }
}
