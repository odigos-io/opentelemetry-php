<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\Illuminate\Queue;

use Odigos\Illuminate\Queue\Queue as AbstractQueue;
use OpenTelemetry\API\Trace\Propagation\TraceContextPropagator;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\LaravelHook;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\LaravelHookTrait;
use function OpenTelemetry\Instrumentation\hook;
use Throwable;
class Queue implements LaravelHook
{
    use AttributesBuilder;
    use LaravelHookTrait;
    public function instrument(): void
    {
        $this->hookAbstractQueueCreatePayloadArray();
    }
    /** @psalm-suppress PossiblyUnusedReturnValue */
    protected function hookAbstractQueueCreatePayloadArray(): bool
    {
        return hook('Illuminate\\Queue\\Queue', 'createPayloadArray', post: function (object $_queue, array $_params, array $payload, ?Throwable $_exception): array {
            TraceContextPropagator::getInstance()->inject($payload);
            return $payload;
        });
    }
}
