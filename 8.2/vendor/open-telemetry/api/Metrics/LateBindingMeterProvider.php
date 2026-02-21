<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Metrics;

use Closure;
class LateBindingMeterProvider implements \OpenTelemetry\API\Metrics\MeterProviderInterface
{
    private ?\OpenTelemetry\API\Metrics\MeterProviderInterface $meterProvider = null;
    /** @param Closure(): MeterProviderInterface $factory */
    public function __construct(private readonly Closure $factory)
    {
    }
    #[\Override]
    public function getMeter(string $name, ?string $version = null, ?string $schemaUrl = null, iterable $attributes = []): \OpenTelemetry\API\Metrics\MeterInterface
    {
        return $this->meterProvider?->getMeter($name, $version, $schemaUrl, $attributes) ?? new \OpenTelemetry\API\Metrics\LateBindingMeter(fn(): \OpenTelemetry\API\Metrics\MeterInterface => ($this->meterProvider ??= ($this->factory)())->getMeter($name, $version, $schemaUrl, $attributes));
    }
}
