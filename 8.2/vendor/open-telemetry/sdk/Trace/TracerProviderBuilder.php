<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\SDK\Common\InstrumentationScope\Configurator;
use OpenTelemetry\SDK\Resource\ResourceInfo;
use OpenTelemetry\SDK\Trace\SpanSuppression\NoopSuppressionStrategy\NoopSuppressionStrategy;
use OpenTelemetry\SDK\Trace\SpanSuppression\SpanSuppressionStrategy;
class TracerProviderBuilder
{
    /** @var list<SpanProcessorInterface> */
    private ?array $spanProcessors = [];
    private ?ResourceInfo $resource = null;
    private ?\OpenTelemetry\SDK\Trace\SamplerInterface $sampler = null;
    private ?Configurator $configurator = null;
    private ?SpanSuppressionStrategy $spanSuppressionStrategy = null;
    public function addSpanProcessor(\OpenTelemetry\SDK\Trace\SpanProcessorInterface $spanProcessor): self
    {
        $this->spanProcessors[] = $spanProcessor;
        return $this;
    }
    public function setResource(ResourceInfo $resource): self
    {
        $this->resource = $resource;
        return $this;
    }
    public function setSampler(\OpenTelemetry\SDK\Trace\SamplerInterface $sampler): self
    {
        $this->sampler = $sampler;
        return $this;
    }
    public function setConfigurator(Configurator $configurator): self
    {
        $this->configurator = $configurator;
        return $this;
    }
    public function setSpanSuppressionStrategy(SpanSuppressionStrategy $spanSuppressionStrategy): self
    {
        $this->spanSuppressionStrategy = $spanSuppressionStrategy;
        return $this;
    }
    public function build(): \OpenTelemetry\SDK\Trace\TracerProviderInterface
    {
        return new \OpenTelemetry\SDK\Trace\TracerProvider($this->spanProcessors, $this->sampler, $this->resource, configurator: $this->configurator ?? Configurator::tracer(), spanSuppressionStrategy: $this->spanSuppressionStrategy ?? new NoopSuppressionStrategy());
    }
}
