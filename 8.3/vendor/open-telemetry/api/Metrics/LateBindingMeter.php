<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Metrics;

use Closure;
/**
 * @psalm-suppress InvalidArgument
 */
class LateBindingMeter implements \OpenTelemetry\API\Metrics\MeterInterface
{
    private ?\OpenTelemetry\API\Metrics\MeterInterface $meter = null;
    /** @param Closure(): MeterInterface $factory */
    public function __construct(private readonly Closure $factory)
    {
    }
    #[\Override]
    public function batchObserve(callable $callback, \OpenTelemetry\API\Metrics\AsynchronousInstrument $instrument, \OpenTelemetry\API\Metrics\AsynchronousInstrument ...$instruments): \OpenTelemetry\API\Metrics\ObservableCallbackInterface
    {
        return ($this->meter ??= ($this->factory)())->batchObserve($callback, $instrument, ...$instruments);
    }
    #[\Override]
    public function createCounter(string $name, ?string $unit = null, ?string $description = null, array $advisory = []): \OpenTelemetry\API\Metrics\CounterInterface
    {
        return ($this->meter ??= ($this->factory)())->createCounter($name, $unit, $description, $advisory);
    }
    #[\Override]
    public function createObservableCounter(string $name, ?string $unit = null, ?string $description = null, callable|array $advisory = [], callable ...$callbacks): \OpenTelemetry\API\Metrics\ObservableCounterInterface
    {
        return ($this->meter ??= ($this->factory)())->createObservableCounter($name, $unit, $description, $advisory, ...$callbacks);
    }
    #[\Override]
    public function createHistogram(string $name, ?string $unit = null, ?string $description = null, array $advisory = []): \OpenTelemetry\API\Metrics\HistogramInterface
    {
        return ($this->meter ??= ($this->factory)())->createHistogram($name, $unit, $description, $advisory);
    }
    #[\Override]
    public function createGauge(string $name, ?string $unit = null, ?string $description = null, array $advisory = []): \OpenTelemetry\API\Metrics\GaugeInterface
    {
        return ($this->meter ??= ($this->factory)())->createGauge($name, $unit, $description, $advisory);
    }
    #[\Override]
    public function createObservableGauge(string $name, ?string $unit = null, ?string $description = null, callable|array $advisory = [], callable ...$callbacks): \OpenTelemetry\API\Metrics\ObservableGaugeInterface
    {
        return ($this->meter ??= ($this->factory)())->createObservableGauge($name, $unit, $description, $advisory, ...$callbacks);
    }
    #[\Override]
    public function createUpDownCounter(string $name, ?string $unit = null, ?string $description = null, array $advisory = []): \OpenTelemetry\API\Metrics\UpDownCounterInterface
    {
        return ($this->meter ??= ($this->factory)())->createUpDownCounter($name, $unit, $description, $advisory);
    }
    #[\Override]
    public function createObservableUpDownCounter(string $name, ?string $unit = null, ?string $description = null, callable|array $advisory = [], callable ...$callbacks): \OpenTelemetry\API\Metrics\ObservableUpDownCounterInterface
    {
        return ($this->meter ??= ($this->factory)())->createObservableUpDownCounter($name, $unit, $description, $advisory, ...$callbacks);
    }
}
