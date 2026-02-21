<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics\Stream;

use OpenTelemetry\SDK\Metrics\AggregationInterface;
use OpenTelemetry\SDK\Metrics\AttributeProcessorInterface;
/**
 * @internal
 */
final class MetricAggregatorFactory implements \OpenTelemetry\SDK\Metrics\Stream\MetricAggregatorFactoryInterface
{
    public function __construct(private readonly ?AttributeProcessorInterface $attributeProcessor, private readonly AggregationInterface $aggregation)
    {
    }
    #[\Override]
    public function create(): \OpenTelemetry\SDK\Metrics\Stream\MetricAggregatorInterface
    {
        return new \OpenTelemetry\SDK\Metrics\Stream\MetricAggregator($this->attributeProcessor, $this->aggregation);
    }
}
