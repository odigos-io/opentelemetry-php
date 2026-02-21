<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics;

trait DefaultAggregationProviderTrait
{
    public function defaultAggregation($instrumentType, array $advisory = []): ?\OpenTelemetry\SDK\Metrics\AggregationInterface
    {
        return match ($instrumentType) {
            \OpenTelemetry\SDK\Metrics\InstrumentType::COUNTER, \OpenTelemetry\SDK\Metrics\InstrumentType::ASYNCHRONOUS_COUNTER => new \OpenTelemetry\SDK\Metrics\Aggregation\SumAggregation(\true),
            \OpenTelemetry\SDK\Metrics\InstrumentType::UP_DOWN_COUNTER, \OpenTelemetry\SDK\Metrics\InstrumentType::ASYNCHRONOUS_UP_DOWN_COUNTER => new \OpenTelemetry\SDK\Metrics\Aggregation\SumAggregation(),
            \OpenTelemetry\SDK\Metrics\InstrumentType::HISTOGRAM => new \OpenTelemetry\SDK\Metrics\Aggregation\ExplicitBucketHistogramAggregation($advisory['ExplicitBucketBoundaries'] ?? [0, 5, 10, 25, 50, 75, 100, 250, 500, 1000]),
            \OpenTelemetry\SDK\Metrics\InstrumentType::GAUGE, \OpenTelemetry\SDK\Metrics\InstrumentType::ASYNCHRONOUS_GAUGE => new \OpenTelemetry\SDK\Metrics\Aggregation\LastValueAggregation(),
            default => null,
        };
    }
}
