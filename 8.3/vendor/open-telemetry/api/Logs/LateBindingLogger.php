<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Logs;

use Closure;
use OpenTelemetry\Context\ContextInterface;
class LateBindingLogger implements \OpenTelemetry\API\Logs\LoggerInterface
{
    private ?\OpenTelemetry\API\Logs\LoggerInterface $logger = null;
    /** @param Closure(): LoggerInterface $factory */
    public function __construct(private readonly Closure $factory)
    {
    }
    #[\Override]
    public function emit(\OpenTelemetry\API\Logs\LogRecord $logRecord): void
    {
        ($this->logger ??= ($this->factory)())->emit($logRecord);
    }
    #[\Override]
    public function isEnabled(?ContextInterface $context = null, ?int $severityNumber = null, ?string $eventName = null): bool
    {
        return \true;
    }
}
