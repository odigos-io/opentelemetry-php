<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Driver\OCI8\Exception;

use Odigos\Doctrine\DBAL\Driver\AbstractException;
/** @internal */
final class InvalidConfiguration extends AbstractException
{
    public static function forPersistentAndExclusive(): self
    {
        return new self('The "persistent" parameter and the "exclusive" driver option are mutually exclusive');
    }
}
