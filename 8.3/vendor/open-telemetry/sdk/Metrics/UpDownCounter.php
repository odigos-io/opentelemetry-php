<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics;

use OpenTelemetry\API\Metrics\UpDownCounterInterface;
/**
 * @internal
 */
final class UpDownCounter implements UpDownCounterInterface, \OpenTelemetry\SDK\Metrics\InstrumentHandle
{
    use \OpenTelemetry\SDK\Metrics\SynchronousInstrumentTrait {
        write as add;
    }
}
