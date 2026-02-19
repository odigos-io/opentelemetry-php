<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics\Stream;

/**
 * @internal
 */
interface MetricAggregatorInterface extends \OpenTelemetry\SDK\Metrics\Stream\WritableMetricStreamInterface, \OpenTelemetry\SDK\Metrics\Stream\MetricCollectorInterface
{
}
