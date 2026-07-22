<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Schema;

use Odigos\Doctrine\DBAL\Platforms\AbstractPlatform;
/**
 * Represents the default expression of a column.
 */
interface DefaultExpression
{
    /**
     * Returns the SQL representation of the default expression for the given platform.
     */
    public function toSQL(AbstractPlatform $platform): string;
}
