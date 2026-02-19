<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Common\Instrumentation;

use OpenTelemetry\SDK\Common\Attribute\AttributesFactoryInterface;
final class InstrumentationScopeFactory implements \OpenTelemetry\SDK\Common\Instrumentation\InstrumentationScopeFactoryInterface
{
    public function __construct(private readonly AttributesFactoryInterface $attributesFactory)
    {
    }
    #[\Override]
    public function create(string $name, ?string $version = null, ?string $schemaUrl = null, iterable $attributes = []): \OpenTelemetry\SDK\Common\Instrumentation\InstrumentationScopeInterface
    {
        return new \OpenTelemetry\SDK\Common\Instrumentation\InstrumentationScope($name, $version, $schemaUrl, $this->attributesFactory->builder($attributes)->build());
    }
}
