<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Exception;

use Odigos\Doctrine\DBAL\ConnectionException;
final class NoActiveTransaction extends ConnectionException
{
    public static function new(): self
    {
        return new self('There is no active transaction.');
    }
}
