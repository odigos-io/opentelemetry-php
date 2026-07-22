<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Schema\Exception;

use Odigos\Doctrine\DBAL\Schema\SchemaException;
use LogicException;
use function sprintf;
final class NamespaceAlreadyExists extends LogicException implements SchemaException
{
    public static function new(string $namespaceName): self
    {
        return new self(sprintf('The namespace with name "%s" already exists.', $namespaceName));
    }
}
