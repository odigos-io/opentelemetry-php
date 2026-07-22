<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Exception;

use Odigos\Doctrine\DBAL\ConnectionException;
final class SavepointsNotSupported extends ConnectionException
{
    public static function new(): self
    {
        return new self('Savepoints are not supported by this driver.');
    }
}
