<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Driver;

use Odigos\Doctrine\DBAL\Driver;
use Odigos\Doctrine\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Odigos\Doctrine\DBAL\Driver\API\SQLite\ExceptionConverter;
use Odigos\Doctrine\DBAL\Platforms\SQLitePlatform;
use Odigos\Doctrine\DBAL\ServerVersionProvider;
/**
 * Abstract base implementation of the {@see Driver} interface for SQLite based drivers.
 */
abstract class AbstractSQLiteDriver implements Driver
{
    public function getDatabasePlatform(ServerVersionProvider $versionProvider): SQLitePlatform
    {
        return new SQLitePlatform();
    }
    public function getExceptionConverter(): ExceptionConverterInterface
    {
        return new ExceptionConverter();
    }
}
