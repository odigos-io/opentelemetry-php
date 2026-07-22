<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Schema\DefaultExpression;

use Odigos\Doctrine\DBAL\Platforms\AbstractPlatform;
use Odigos\Doctrine\DBAL\Schema\DefaultExpression;
/**
 * Represents the "current time" default expression.
 */
final readonly class CurrentTime implements DefaultExpression
{
    public function toSQL(AbstractPlatform $platform): string
    {
        return $platform->getCurrentTimeSQL();
    }
}
