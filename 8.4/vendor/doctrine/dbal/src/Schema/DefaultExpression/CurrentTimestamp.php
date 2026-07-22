<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Schema\DefaultExpression;

use Odigos\Doctrine\DBAL\Platforms\AbstractPlatform;
use Odigos\Doctrine\DBAL\Schema\DefaultExpression;
/**
 * Represents the "current timestamp" default expression.
 */
final readonly class CurrentTimestamp implements DefaultExpression
{
    public function toSQL(AbstractPlatform $platform): string
    {
        return $platform->getCurrentTimestampSQL();
    }
}
