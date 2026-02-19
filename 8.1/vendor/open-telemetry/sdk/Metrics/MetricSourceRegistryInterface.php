<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics;

interface MetricSourceRegistryInterface
{
    public function add(\OpenTelemetry\SDK\Metrics\MetricSourceProviderInterface $provider, \OpenTelemetry\SDK\Metrics\MetricMetadataInterface $metadata, \OpenTelemetry\SDK\Metrics\StalenessHandlerInterface $stalenessHandler): void;
}
