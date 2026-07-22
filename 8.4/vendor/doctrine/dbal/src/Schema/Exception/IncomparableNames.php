<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Schema\Exception;

use Odigos\Doctrine\DBAL\Schema\Name\OptionallyQualifiedName;
use Odigos\Doctrine\DBAL\Schema\SchemaException;
use LogicException;
use function sprintf;
final class IncomparableNames extends LogicException implements SchemaException
{
    public static function fromOptionallyQualifiedNames(OptionallyQualifiedName $name1, OptionallyQualifiedName $name2): self
    {
        return new self(sprintf('Non-equally qualified names are incomparable: %s, %s.', $name1->toString(), $name2->toString()));
    }
}
