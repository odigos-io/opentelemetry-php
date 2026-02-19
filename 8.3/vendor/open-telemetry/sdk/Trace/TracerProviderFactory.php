<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\API\Behavior\LogsMessagesTrait;
use OpenTelemetry\SDK\Sdk;
final class TracerProviderFactory
{
    use LogsMessagesTrait;
    public function __construct(private readonly \OpenTelemetry\SDK\Trace\ExporterFactory $exporterFactory = new \OpenTelemetry\SDK\Trace\ExporterFactory(), private readonly \OpenTelemetry\SDK\Trace\SamplerFactory $samplerFactory = new \OpenTelemetry\SDK\Trace\SamplerFactory(), private readonly \OpenTelemetry\SDK\Trace\SpanProcessorFactory $spanProcessorFactory = new \OpenTelemetry\SDK\Trace\SpanProcessorFactory())
    {
    }
    public function create(): \OpenTelemetry\SDK\Trace\TracerProviderInterface
    {
        if (Sdk::isDisabled()) {
            return new \OpenTelemetry\SDK\Trace\NoopTracerProvider();
        }
        try {
            $exporter = $this->exporterFactory->create();
        } catch (\Throwable $t) {
            self::logWarning('Unable to create exporter', ['exception' => $t]);
            $exporter = null;
        }
        try {
            $sampler = $this->samplerFactory->create();
        } catch (\Throwable $t) {
            self::logWarning('Unable to create sampler', ['exception' => $t]);
            $sampler = null;
        }
        try {
            $spanProcessor = $this->spanProcessorFactory->create($exporter);
        } catch (\Throwable $t) {
            self::logWarning('Unable to create span processor', ['exception' => $t]);
            $spanProcessor = null;
        }
        return new \OpenTelemetry\SDK\Trace\TracerProvider($spanProcessor, $sampler);
    }
}
