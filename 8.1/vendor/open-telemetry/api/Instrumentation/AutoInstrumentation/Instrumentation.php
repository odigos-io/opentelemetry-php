<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Instrumentation\AutoInstrumentation;

use OpenTelemetry\API\Configuration\ConfigProperties;
interface Instrumentation
{
    public function register(\OpenTelemetry\API\Instrumentation\AutoInstrumentation\HookManagerInterface $hookManager, ConfigProperties $configuration, \OpenTelemetry\API\Instrumentation\AutoInstrumentation\Context $context): void;
}
