<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
/**
 * Type generating json objects values
 */
class JsonObjectType extends \Doctrine\DBAL\Types\Type
{
    use \Doctrine\DBAL\Types\JsonTypeConvert;
    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }
    protected function isAssociative(): bool
    {
        return \false;
    }
}
