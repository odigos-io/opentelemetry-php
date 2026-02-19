<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Logs;

use OpenTelemetry\SDK\Common\Instrumentation\InstrumentationScopeFactory;
use OpenTelemetry\SDK\Metrics\MeterProviderInterface;
use OpenTelemetry\SDK\Resource\ResourceInfo;
use OpenTelemetry\SDK\Sdk;
class LoggerProviderFactory
{
    public function create(?MeterProviderInterface $meterProvider = null, ?ResourceInfo $resource = null): \OpenTelemetry\SDK\Logs\LoggerProviderInterface
    {
        if (Sdk::isDisabled()) {
            return \OpenTelemetry\SDK\Logs\NoopLoggerProvider::getInstance();
        }
        $exporter = (new \OpenTelemetry\SDK\Logs\ExporterFactory())->create();
        $processor = (new \OpenTelemetry\SDK\Logs\LogRecordProcessorFactory())->create($exporter, $meterProvider);
        $instrumentationScopeFactory = new InstrumentationScopeFactory((new \OpenTelemetry\SDK\Logs\LogRecordLimitsBuilder())->build()->getAttributeFactory());
        return new \OpenTelemetry\SDK\Logs\LoggerProvider($processor, $instrumentationScopeFactory, $resource);
    }
}
