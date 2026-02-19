<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Trace;

use OpenTelemetry\Context\Context;
final class NoopTracer implements \OpenTelemetry\API\Trace\TracerInterface
{
    private static ?self $instance = null;
    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    #[\Override]
    public function spanBuilder(string $spanName): \OpenTelemetry\API\Trace\SpanBuilderInterface
    {
        return new \OpenTelemetry\API\Trace\NoopSpanBuilder(Context::storage());
    }
    #[\Override]
    public function isEnabled(): bool
    {
        return \false;
    }
}
