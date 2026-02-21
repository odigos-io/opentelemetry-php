<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Trace\SpanProcessor;

use OpenTelemetry\API\Common\Time\Clock;
use OpenTelemetry\SDK\Metrics\MeterProviderInterface;
use OpenTelemetry\SDK\Trace\SpanExporterInterface;
class BatchSpanProcessorBuilder
{
    private ?MeterProviderInterface $meterProvider = null;
    public function __construct(private readonly SpanExporterInterface $exporter)
    {
    }
    public function setMeterProvider(MeterProviderInterface $meterProvider): self
    {
        $this->meterProvider = $meterProvider;
        return $this;
    }
    public function build(): \OpenTelemetry\SDK\Trace\SpanProcessor\BatchSpanProcessor
    {
        return new \OpenTelemetry\SDK\Trace\SpanProcessor\BatchSpanProcessor($this->exporter, Clock::getDefault(), \OpenTelemetry\SDK\Trace\SpanProcessor\BatchSpanProcessor::DEFAULT_MAX_QUEUE_SIZE, \OpenTelemetry\SDK\Trace\SpanProcessor\BatchSpanProcessor::DEFAULT_SCHEDULE_DELAY, \OpenTelemetry\SDK\Trace\SpanProcessor\BatchSpanProcessor::DEFAULT_EXPORT_TIMEOUT, \OpenTelemetry\SDK\Trace\SpanProcessor\BatchSpanProcessor::DEFAULT_MAX_EXPORT_BATCH_SIZE, \true, $this->meterProvider);
    }
}
