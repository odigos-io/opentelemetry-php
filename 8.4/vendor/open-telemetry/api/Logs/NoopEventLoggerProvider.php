<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Logs;

/**
 * @phan-suppress PhanDeprecatedInterface
 */
class NoopEventLoggerProvider implements \OpenTelemetry\API\Logs\EventLoggerProviderInterface
{
    public static function getInstance(): self
    {
        static $instance;
        return $instance ??= new self();
    }
    #[\Override]
    public function getEventLogger(string $name, ?string $version = null, ?string $schemaUrl = null, iterable $attributes = []): \OpenTelemetry\API\Logs\EventLoggerInterface
    {
        return \OpenTelemetry\API\Logs\NoopEventLogger::instance();
    }
}
