<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Schema\Exception;

use Odigos\Doctrine\DBAL\Schema\Name\UnqualifiedName;
use Odigos\Doctrine\DBAL\Schema\SchemaException;
use LogicException;
use function sprintf;
/** @psalm-immutable */
final class InvalidColumnDefinition extends LogicException implements SchemaException
{
    public static function nameNotSpecified(): self
    {
        return new self('Column name is not specified.');
    }
    public static function dataTypeNotSpecified(UnqualifiedName $columnName): self
    {
        return new self(sprintf('Data type is not specified for column %s.', $columnName->toString()));
    }
}
