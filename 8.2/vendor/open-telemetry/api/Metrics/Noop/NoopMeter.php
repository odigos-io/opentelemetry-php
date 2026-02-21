<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Metrics\Noop;

use OpenTelemetry\API\Metrics\AsynchronousInstrument;
use OpenTelemetry\API\Metrics\CounterInterface;
use OpenTelemetry\API\Metrics\GaugeInterface;
use OpenTelemetry\API\Metrics\HistogramInterface;
use OpenTelemetry\API\Metrics\MeterInterface;
use OpenTelemetry\API\Metrics\ObservableCallbackInterface;
use OpenTelemetry\API\Metrics\ObservableCounterInterface;
use OpenTelemetry\API\Metrics\ObservableGaugeInterface;
use OpenTelemetry\API\Metrics\ObservableUpDownCounterInterface;
use OpenTelemetry\API\Metrics\UpDownCounterInterface;
final class NoopMeter implements MeterInterface
{
    #[\Override]
    public function batchObserve(callable $callback, AsynchronousInstrument $instrument, AsynchronousInstrument ...$instruments): ObservableCallbackInterface
    {
        return new \OpenTelemetry\API\Metrics\Noop\NoopObservableCallback();
    }
    #[\Override]
    public function createCounter(string $name, ?string $unit = null, ?string $description = null, array $advisory = []): CounterInterface
    {
        return new \OpenTelemetry\API\Metrics\Noop\NoopCounter();
    }
    #[\Override]
    public function createObservableCounter(string $name, ?string $unit = null, ?string $description = null, $advisory = [], callable ...$callbacks): ObservableCounterInterface
    {
        return new \OpenTelemetry\API\Metrics\Noop\NoopObservableCounter();
    }
    #[\Override]
    public function createHistogram(string $name, ?string $unit = null, ?string $description = null, array $advisory = []): HistogramInterface
    {
        return new \OpenTelemetry\API\Metrics\Noop\NoopHistogram();
    }
    #[\Override]
    public function createGauge(string $name, ?string $unit = null, ?string $description = null, array $advisory = []): GaugeInterface
    {
        return new \OpenTelemetry\API\Metrics\Noop\NoopGauge();
    }
    #[\Override]
    public function createObservableGauge(string $name, ?string $unit = null, ?string $description = null, $advisory = [], callable ...$callbacks): ObservableGaugeInterface
    {
        return new \OpenTelemetry\API\Metrics\Noop\NoopObservableGauge();
    }
    #[\Override]
    public function createUpDownCounter(string $name, ?string $unit = null, ?string $description = null, array $advisory = []): UpDownCounterInterface
    {
        return new \OpenTelemetry\API\Metrics\Noop\NoopUpDownCounter();
    }
    #[\Override]
    public function createObservableUpDownCounter(string $name, ?string $unit = null, ?string $description = null, $advisory = [], callable ...$callbacks): ObservableUpDownCounterInterface
    {
        return new \OpenTelemetry\API\Metrics\Noop\NoopObservableUpDownCounter();
    }
}
