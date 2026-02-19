<?php

declare (strict_types=1);
namespace OpenTelemetry\Contrib\Instrumentation\CakePHP\Hooks;

use OpenTelemetry\API\Instrumentation\CachedInstrumentation;
interface CakeHook
{
    public static function hook(CachedInstrumentation $instrumentation): \OpenTelemetry\Contrib\Instrumentation\CakePHP\Hooks\CakeHook;
    public function instrument(): void;
}
