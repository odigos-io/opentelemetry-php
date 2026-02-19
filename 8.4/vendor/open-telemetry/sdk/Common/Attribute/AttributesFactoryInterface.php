<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Common\Attribute;

interface AttributesFactoryInterface
{
    public function builder(iterable $attributes = [], ?\OpenTelemetry\SDK\Common\Attribute\AttributeValidatorInterface $attributeValidator = null): \OpenTelemetry\SDK\Common\Attribute\AttributesBuilderInterface;
}
