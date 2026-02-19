<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Configuration;

interface ConfigProviderInterface
{
    public function getInstrumentationConfig(): \OpenTelemetry\API\Configuration\ConfigProperties;
}
