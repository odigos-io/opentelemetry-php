<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Types;

use Odigos\Doctrine\DBAL\Platforms\AbstractPlatform;
/**
 * Type generating JSON objects values stored in JSONB columns.
 */
class JsonbType extends JsonType
{
    /**
     * {@inheritDoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonbTypeDeclarationSQL($column);
    }
}
