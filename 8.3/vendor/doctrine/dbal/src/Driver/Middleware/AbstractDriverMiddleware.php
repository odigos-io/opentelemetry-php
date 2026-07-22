<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Driver\Middleware;

use Odigos\Doctrine\DBAL\Driver;
use Odigos\Doctrine\DBAL\Driver\API\ExceptionConverter;
use Odigos\Doctrine\DBAL\Driver\Connection as DriverConnection;
use Odigos\Doctrine\DBAL\Platforms\AbstractPlatform;
use Odigos\Doctrine\DBAL\ServerVersionProvider;
use SensitiveParameter;
abstract class AbstractDriverMiddleware implements Driver
{
    public function __construct(private readonly Driver $wrappedDriver)
    {
    }
    /**
     * {@inheritDoc}
     */
    public function connect(
        #[SensitiveParameter]
        array $params
    ): DriverConnection
    {
        return $this->wrappedDriver->connect($params);
    }
    public function getDatabasePlatform(ServerVersionProvider $versionProvider): AbstractPlatform
    {
        return $this->wrappedDriver->getDatabasePlatform($versionProvider);
    }
    public function getExceptionConverter(): ExceptionConverter
    {
        return $this->wrappedDriver->getExceptionConverter();
    }
}
