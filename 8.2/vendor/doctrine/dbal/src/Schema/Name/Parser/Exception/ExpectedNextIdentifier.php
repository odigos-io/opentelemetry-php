<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Schema\Name\Parser\Exception;

use Odigos\Doctrine\DBAL\Schema\Name\Parser\Exception;
use LogicException;
/** @internal */
class ExpectedNextIdentifier extends LogicException implements Exception
{
    public static function new(): self
    {
        return new self('Unexpected end of input. Next identifier expected.');
    }
}
