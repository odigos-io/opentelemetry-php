<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Schema\Exception;

use Odigos\Doctrine\DBAL\Schema\SchemaException;
use LogicException;
use function sprintf;
final class UniqueConstraintDoesNotExist extends LogicException implements SchemaException
{
    public static function new(string $constraintName, string $table): self
    {
        return new self(sprintf('There exists no unique constraint with the name "%s" on table "%s".', $constraintName, $table));
    }
}
