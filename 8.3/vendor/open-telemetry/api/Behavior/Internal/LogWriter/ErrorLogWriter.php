<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Behavior\Internal\LogWriter;

class ErrorLogWriter implements \OpenTelemetry\API\Behavior\Internal\LogWriter\LogWriterInterface
{
    #[\Override]
    public function write($level, string $message, array $context): void
    {
        error_log(\OpenTelemetry\API\Behavior\Internal\LogWriter\Formatter::format($level, $message, $context));
    }
}
