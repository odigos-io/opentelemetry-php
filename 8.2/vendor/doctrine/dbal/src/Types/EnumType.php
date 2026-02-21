<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
final class EnumType extends \Doctrine\DBAL\Types\Type
{
    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getEnumDeclarationSQL($column);
    }
}
