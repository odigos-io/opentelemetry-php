<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics;

use OpenTelemetry\API\Metrics\CounterInterface;
/**
 * @internal
 */
final class Counter implements CounterInterface, \OpenTelemetry\SDK\Metrics\InstrumentHandle
{
    use \OpenTelemetry\SDK\Metrics\SynchronousInstrumentTrait {
        write as add;
    }
}
