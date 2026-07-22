<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Exception;

use Odigos\Doctrine\DBAL\Exception;
use Odigos\Doctrine\DBAL\SQL\Parser;
/** @internal */
final class ParseError extends \Exception implements Exception
{
    public static function fromParserException(Parser\Exception $exception): self
    {
        return new self('Unable to parse query.', 0, $exception);
    }
}
