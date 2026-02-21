<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics;

use function assert;
use OpenTelemetry\SDK\Metrics\MetricRegistry\MetricWriterInterface;
/**
 * @internal
 */
trait SynchronousInstrumentTrait
{
    private MetricWriterInterface $writer;
    private \OpenTelemetry\SDK\Metrics\Instrument $instrument;
    private \OpenTelemetry\SDK\Metrics\ReferenceCounterInterface $referenceCounter;
    public function __construct(MetricWriterInterface $writer, \OpenTelemetry\SDK\Metrics\Instrument $instrument, \OpenTelemetry\SDK\Metrics\ReferenceCounterInterface $referenceCounter)
    {
        assert($this instanceof \OpenTelemetry\SDK\Metrics\InstrumentHandle);
        $this->writer = $writer;
        $this->instrument = $instrument;
        $this->referenceCounter = $referenceCounter;
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
    public function write($amount, iterable $attributes = [], $context = null): void
    {
        if ($this->isEnabled()) {
            $this->writer->record($this->instrument, $amount, $attributes, $context);
        }
    }
    public function isEnabled(): bool
    {
        return $this->writer->enabled($this->instrument);
    }
}
