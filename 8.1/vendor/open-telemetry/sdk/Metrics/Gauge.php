<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics;

use OpenTelemetry\API\Metrics\GaugeInterface;
/**
 * @internal
 */
final class Gauge implements GaugeInterface, \OpenTelemetry\SDK\Metrics\InstrumentHandle
{
    use \OpenTelemetry\SDK\Metrics\SynchronousInstrumentTrait {
        write as record;
    }
}
