<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Common\Attribute;

use ArrayAccess;
/**
 * @psalm-suppress MissingTemplateParam
 */
interface AttributesBuilderInterface extends ArrayAccess
{
    public function build(): \OpenTelemetry\SDK\Common\Attribute\AttributesInterface;
    public function merge(\OpenTelemetry\SDK\Common\Attribute\AttributesInterface $old, \OpenTelemetry\SDK\Common\Attribute\AttributesInterface $updating): \OpenTelemetry\SDK\Common\Attribute\AttributesInterface;
}
