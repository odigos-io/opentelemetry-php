<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Metrics\Noop;

use OpenTelemetry\API\Metrics\ObservableCallbackInterface;
use OpenTelemetry\API\Metrics\ObservableCounterInterface;
/**
 * @internal
 */
final class NoopObservableCounter implements ObservableCounterInterface
{
    #[\Override]
    public function observe(callable $callback, bool $weaken = \false): ObservableCallbackInterface
    {
        return new \OpenTelemetry\API\Metrics\Noop\NoopObservableCallback();
    }
    #[\Override]
    public function isEnabled(): bool
    {
        return \false;
    }
}
