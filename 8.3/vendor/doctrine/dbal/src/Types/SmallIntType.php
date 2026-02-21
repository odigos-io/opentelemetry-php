<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Types;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
/**
 * Type that maps a database SMALLINT to a PHP integer.
 */
class SmallIntType extends \Doctrine\DBAL\Types\Type implements \Doctrine\DBAL\Types\PhpIntegerMappingType
{
    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getSmallIntTypeDeclarationSQL($column);
    }
    /**
     * @param T $value
     *
     * @return (T is null ? null : int)
     *
     * @template T
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?int
    {
        return $value === null ? null : (int) $value;
    }
    public function getBindingType(): ParameterType
    {
        return ParameterType::INTEGER;
    }
}
