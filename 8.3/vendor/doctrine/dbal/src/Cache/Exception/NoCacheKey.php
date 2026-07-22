<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Cache\Exception;

use Odigos\Doctrine\DBAL\Cache\CacheException;
final class NoCacheKey extends CacheException
{
    public static function new(): self
    {
        return new self('No cache key was set.');
    }
}
