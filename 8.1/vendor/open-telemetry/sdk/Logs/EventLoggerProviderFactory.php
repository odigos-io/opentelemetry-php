<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Logs;

use OpenTelemetry\SDK\Sdk;
/**
 * @deprecated
 */
class EventLoggerProviderFactory
{
    public function create(\OpenTelemetry\SDK\Logs\LoggerProviderInterface $loggerProvider): \OpenTelemetry\SDK\Logs\EventLoggerProviderInterface
    {
        if (Sdk::isDisabled()) {
            return \OpenTelemetry\SDK\Logs\NoopEventLoggerProvider::getInstance();
        }
        return new \OpenTelemetry\SDK\Logs\EventLoggerProvider($loggerProvider);
    }
}
