<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Metrics;

/**
 * @internal
 */
interface MetricRegistrationInterface
{
    public function register(\OpenTelemetry\SDK\Metrics\MetricSourceProviderInterface $provider, \OpenTelemetry\SDK\Metrics\MetricMetadataInterface $metadata): void;
}
