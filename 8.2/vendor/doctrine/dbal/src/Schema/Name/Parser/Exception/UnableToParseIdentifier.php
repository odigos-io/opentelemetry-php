<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Schema\Name\Parser\Exception;

use Odigos\Doctrine\DBAL\Schema\Name\Parser\Exception;
use LogicException;
use function sprintf;
/** @internal */
class UnableToParseIdentifier extends LogicException implements Exception
{
    public static function new(int $offset): self
    {
        return new self(sprintf('Unable to parse identifier at offset %d.', $offset));
    }
}
