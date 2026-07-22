<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Types;

use Odigos\Doctrine\DBAL\ParameterType;
use Odigos\Doctrine\DBAL\Platforms\AbstractPlatform;
final class AsciiStringType extends StringType
{
    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getAsciiStringTypeDeclarationSQL($column);
    }
    public function getBindingType(): ParameterType
    {
        return ParameterType::ASCII;
    }
}
