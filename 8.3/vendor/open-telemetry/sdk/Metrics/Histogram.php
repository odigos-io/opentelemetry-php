<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics;

use OpenTelemetry\API\Metrics\HistogramInterface;
/**
 * @internal
 */
final class Histogram implements HistogramInterface, \OpenTelemetry\SDK\Metrics\InstrumentHandle
{
    use \OpenTelemetry\SDK\Metrics\SynchronousInstrumentTrait {
        write as record;
    }
}
