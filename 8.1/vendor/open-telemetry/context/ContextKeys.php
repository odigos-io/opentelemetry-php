<?php

declare (strict_types=1);
namespace OpenTelemetry\Context;

/**
 * @psalm-internal OpenTelemetry
 */
final class ContextKeys
{
    public static function span(): \OpenTelemetry\Context\ContextKeyInterface
    {
        static $instance;
        return $instance ??= \OpenTelemetry\Context\Context::createKey('opentelemetry-trace-span-key');
    }
    public static function baggage(): \OpenTelemetry\Context\ContextKeyInterface
    {
        static $instance;
        return $instance ??= \OpenTelemetry\Context\Context::createKey('opentelemetry-trace-baggage-key');
    }
}
