<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Portability;

use Doctrine\DBAL\ColumnCase;
use Doctrine\DBAL\Driver as DriverInterface;
use Doctrine\DBAL\Driver\Connection as ConnectionInterface;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\Driver\Middleware\AbstractDriverMiddleware;
use Doctrine\DBAL\Platforms\Exception\PlatformException;
use PDO;
use SensitiveParameter;
use const CASE_LOWER;
use const CASE_UPPER;
final class Driver extends AbstractDriverMiddleware
{
    public function __construct(DriverInterface $driver, private readonly int $mode, private readonly ?ColumnCase $case)
    {
        parent::__construct($driver);
    }
    /**
     * {@inheritDoc}
     *
     * @throws PlatformException
     * @throws Exception
     */
    public function connect(
        #[SensitiveParameter]
        array $params
    ): ConnectionInterface
    {
        $connection = parent::connect($params);
        $portability = (new \Doctrine\DBAL\Portability\OptimizeFlags())($this->getDatabasePlatform($connection), $this->mode);
        $case = null;
        if ($this->case !== null && ($portability & \Doctrine\DBAL\Portability\Connection::PORTABILITY_FIX_CASE) !== 0) {
            $nativeConnection = $connection->getNativeConnection();
            $case = match ($this->case) {
                ColumnCase::LOWER => CASE_LOWER,
                ColumnCase::UPPER => CASE_UPPER,
            };
            if ($nativeConnection instanceof PDO) {
                $portability &= ~\Doctrine\DBAL\Portability\Connection::PORTABILITY_FIX_CASE;
                $nativeConnection->setAttribute(PDO::ATTR_CASE, $case);
            }
        }
        $convertEmptyStringToNull = ($portability & \Doctrine\DBAL\Portability\Connection::PORTABILITY_EMPTY_TO_NULL) !== 0;
        $rightTrimString = ($portability & \Doctrine\DBAL\Portability\Connection::PORTABILITY_RTRIM) !== 0;
        if (!$convertEmptyStringToNull && !$rightTrimString && $case === null) {
            return $connection;
        }
        return new \Doctrine\DBAL\Portability\Connection($connection, new \Doctrine\DBAL\Portability\Converter($convertEmptyStringToNull, $rightTrimString, $case));
    }
}
