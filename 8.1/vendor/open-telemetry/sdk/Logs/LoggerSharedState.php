<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Logs;

use OpenTelemetry\SDK\Common\Future\CancellationInterface;
use OpenTelemetry\SDK\Resource\ResourceInfo;
class LoggerSharedState
{
    private ?bool $shutdownResult = null;
    public function __construct(private readonly ResourceInfo $resource, private readonly \OpenTelemetry\SDK\Logs\LogRecordLimits $limits, private readonly \OpenTelemetry\SDK\Logs\LogRecordProcessorInterface $processor)
    {
    }
    public function hasShutdown(): bool
    {
        return null !== $this->shutdownResult;
    }
    public function getResource(): ResourceInfo
    {
        return $this->resource;
    }
    public function getProcessor(): \OpenTelemetry\SDK\Logs\LogRecordProcessorInterface
    {
        return $this->processor;
    }
    public function getLogRecordLimits(): \OpenTelemetry\SDK\Logs\LogRecordLimits
    {
        return $this->limits;
    }
    public function shutdown(?CancellationInterface $cancellation = null): bool
    {
        if ($this->shutdownResult !== null) {
            return $this->shutdownResult;
        }
        $this->shutdownResult = $this->processor->shutdown($cancellation);
        return $this->shutdownResult;
    }
    public function forceFlush(?CancellationInterface $cancellation = null): bool
    {
        return $this->processor->forceFlush($cancellation);
    }
}
