<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics\Data;

final class Histogram implements \OpenTelemetry\SDK\Metrics\Data\DataInterface
{
    /**
     * @param iterable<HistogramDataPoint> $dataPoints
     */
    public function __construct(public readonly iterable $dataPoints, public readonly string|\OpenTelemetry\SDK\Metrics\Data\Temporality $temporality)
    {
    }
}
