<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Common\Attribute;

/**
 * @internal
 */
final class AttributesFactory implements \OpenTelemetry\SDK\Common\Attribute\AttributesFactoryInterface
{
    public function __construct(private readonly ?int $attributeCountLimit = null, private readonly ?int $attributeValueLengthLimit = null)
    {
    }
    #[\Override]
    public function builder(iterable $attributes = [], ?\OpenTelemetry\SDK\Common\Attribute\AttributeValidatorInterface $attributeValidator = null): \OpenTelemetry\SDK\Common\Attribute\AttributesBuilderInterface
    {
        $builder = new \OpenTelemetry\SDK\Common\Attribute\AttributesBuilder([], $this->attributeCountLimit, $this->attributeValueLengthLimit, 0, $attributeValidator ?? new \OpenTelemetry\SDK\Common\Attribute\AttributeValidator());
        foreach ($attributes as $key => $value) {
            $builder[$key] = $value;
        }
        return $builder;
    }
}
