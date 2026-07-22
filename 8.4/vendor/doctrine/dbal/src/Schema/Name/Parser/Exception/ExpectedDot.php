<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Schema\Name\Parser\Exception;

use Odigos\Doctrine\DBAL\Schema\Name\Parser\Exception;
use LogicException;
use function sprintf;
/** @internal */
class ExpectedDot extends LogicException implements Exception
{
    public static function new(int $position, string $got): self
    {
        return new self(sprintf('Expected dot at position %d, got "%s".', $position, $got));
    }
}
