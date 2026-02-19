<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Trace;

use Closure;
class LateBindingTracer implements \OpenTelemetry\API\Trace\TracerInterface
{
    private ?\OpenTelemetry\API\Trace\TracerInterface $tracer = null;
    /** @param Closure(): TracerInterface $factory */
    public function __construct(private readonly Closure $factory)
    {
    }
    #[\Override]
    public function spanBuilder(string $spanName): \OpenTelemetry\API\Trace\SpanBuilderInterface
    {
        return ($this->tracer ??= ($this->factory)())->spanBuilder($spanName);
    }
    #[\Override]
    public function isEnabled(): bool
    {
        return \true;
    }
}
