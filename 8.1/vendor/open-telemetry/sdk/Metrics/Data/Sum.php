<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics\Data;

final class Sum implements \OpenTelemetry\SDK\Metrics\Data\DataInterface
{
    /**
     * @param iterable<NumberDataPoint> $dataPoints
     */
    public function __construct(public readonly iterable $dataPoints, public readonly string|\OpenTelemetry\SDK\Metrics\Data\Temporality $temporality, public readonly bool $monotonic)
    {
    }
}
