<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics;

use ArrayAccess;
use function assert;
use OpenTelemetry\API\Metrics\ObservableCallbackInterface;
use OpenTelemetry\API\Metrics\ObserverInterface;
use OpenTelemetry\SDK\Metrics\MetricRegistry\MetricWriterInterface;
/**
 * @internal
 */
trait ObservableInstrumentTrait
{
    public function __construct(private readonly MetricWriterInterface $writer, private readonly \OpenTelemetry\SDK\Metrics\Instrument $instrument, private readonly \OpenTelemetry\SDK\Metrics\ReferenceCounterInterface $referenceCounter, private readonly ArrayAccess $destructors)
    {
        assert($this instanceof \OpenTelemetry\SDK\Metrics\InstrumentHandle);
        $this->referenceCounter->acquire();
    }
    public function __destruct()
    {
        $this->referenceCounter->release();
    }
    public function getHandle(): \OpenTelemetry\SDK\Metrics\Instrument
    {
        return $this->instrument;
    }
    /**
     * @param callable(ObserverInterface): void $callback
     */
    public function observe(callable $callback): ObservableCallbackInterface
    {
        return \OpenTelemetry\SDK\Metrics\AsynchronousInstruments::observe($this->writer, $this->destructors, $callback, [$this->instrument], $this->referenceCounter);
    }
    public function isEnabled(): bool
    {
        return $this->writer->enabled($this->instrument);
    }
}
