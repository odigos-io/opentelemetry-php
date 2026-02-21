<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Logs;

use OpenTelemetry\API\Common\Time\Clock;
use OpenTelemetry\API\Logs\EventLoggerInterface;
/**
 * @phan-suppress PhanDeprecatedInterface
 */
class EventLoggerProvider implements \OpenTelemetry\SDK\Logs\EventLoggerProviderInterface
{
    public function __construct(private readonly \OpenTelemetry\SDK\Logs\LoggerProviderInterface $loggerProvider)
    {
    }
    /**
     * @phan-suppress PhanDeprecatedClass
     */
    #[\Override]
    public function getEventLogger(string $name, ?string $version = null, ?string $schemaUrl = null, iterable $attributes = []): EventLoggerInterface
    {
        return new \OpenTelemetry\SDK\Logs\EventLogger($this->loggerProvider->getLogger($name, $version, $schemaUrl, $attributes), Clock::getDefault());
    }
    #[\Override]
    public function forceFlush(): bool
    {
        return $this->loggerProvider->forceFlush();
    }
}
