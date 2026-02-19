<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Trace;

class NoopTracerProvider implements \OpenTelemetry\API\Trace\TracerProviderInterface
{
    #[\Override]
    public function getTracer(string $name, ?string $version = null, ?string $schemaUrl = null, iterable $attributes = []): \OpenTelemetry\API\Trace\TracerInterface
    {
        return \OpenTelemetry\API\Trace\NoopTracer::getInstance();
    }
}
