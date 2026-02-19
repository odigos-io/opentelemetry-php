<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Platforms\Exception;

use LogicException;
use function sprintf;
final class NoColumnsSpecifiedForTable extends LogicException implements \Doctrine\DBAL\Platforms\Exception\PlatformException
{
    public static function new(string $tableName): self
    {
        return new self(sprintf('No columns specified for table "%s".', $tableName));
    }
}
