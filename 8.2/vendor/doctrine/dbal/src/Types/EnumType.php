<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Types;

use Odigos\Doctrine\DBAL\Platforms\AbstractPlatform;
final class EnumType extends Type
{
    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getEnumDeclarationSQL($column);
    }
}
