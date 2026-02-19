<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Common\Time;

final class Clock
{
    private static ?\OpenTelemetry\API\Common\Time\ClockInterface $clock = null;
    public static function getDefault(): \OpenTelemetry\API\Common\Time\ClockInterface
    {
        return self::$clock ??= new \OpenTelemetry\API\Common\Time\SystemClock();
    }
    public static function setDefault(\OpenTelemetry\API\Common\Time\ClockInterface $clock): void
    {
        self::$clock = $clock;
    }
    public static function reset(): void
    {
        self::$clock = null;
    }
}
