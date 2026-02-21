<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Logs;

class NoopLoggerProvider implements \OpenTelemetry\API\Logs\LoggerProviderInterface
{
    public static function getInstance(): self
    {
        static $instance;
        return $instance ??= new self();
    }
    #[\Override]
    public function getLogger(string $name, ?string $version = null, ?string $schemaUrl = null, iterable $attributes = []): \OpenTelemetry\API\Logs\LoggerInterface
    {
        return \OpenTelemetry\API\Logs\NoopLogger::getInstance();
    }
}
