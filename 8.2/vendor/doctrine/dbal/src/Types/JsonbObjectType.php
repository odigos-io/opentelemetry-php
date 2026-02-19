<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
/**
 * Type generating json objects values
 */
class JsonbObjectType extends \Doctrine\DBAL\Types\Type
{
    use \Doctrine\DBAL\Types\JsonTypeConvert;
    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonbTypeDeclarationSQL($column);
    }
    protected function isAssociative(): bool
    {
        return \false;
    }
}
