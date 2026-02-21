<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Metrics;

interface ObservableUpDownCounterInterface extends \OpenTelemetry\API\Metrics\AsynchronousInstrument
{
    /**
     * @param callable(ObserverInterface): void $callback function responsible for
     *        reporting the measurements (as absolute values)
     * @return ObservableCallbackInterface token to detach callback
     */
    public function observe(callable $callback): \OpenTelemetry\API\Metrics\ObservableCallbackInterface;
}
