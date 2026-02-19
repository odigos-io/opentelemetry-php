<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Types\Exception;

use Exception;
use function sprintf;
final class TypesAlreadyExists extends Exception implements \Doctrine\DBAL\Types\Exception\TypesException
{
    public static function new(string $name): self
    {
        return new self(sprintf('Type "%s" already exists.', $name));
    }
}
