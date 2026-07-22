<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Schema\Exception;

use Odigos\Doctrine\DBAL\Schema\SchemaException;
use InvalidArgumentException;
final class InvalidName extends InvalidArgumentException implements SchemaException
{
    public static function fromEmpty(): self
    {
        return new self('Name cannot be empty.');
    }
}
