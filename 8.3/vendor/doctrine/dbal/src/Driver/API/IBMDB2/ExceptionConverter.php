<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Driver\API\IBMDB2;

use Odigos\Doctrine\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Odigos\Doctrine\DBAL\Driver\Exception;
use Odigos\Doctrine\DBAL\Exception\ConnectionException;
use Odigos\Doctrine\DBAL\Exception\DriverException;
use Odigos\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Odigos\Doctrine\DBAL\Exception\InvalidFieldNameException;
use Odigos\Doctrine\DBAL\Exception\NonUniqueFieldNameException;
use Odigos\Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Odigos\Doctrine\DBAL\Exception\SyntaxErrorException;
use Odigos\Doctrine\DBAL\Exception\TableExistsException;
use Odigos\Doctrine\DBAL\Exception\TableNotFoundException;
use Odigos\Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Odigos\Doctrine\DBAL\Query;
/**
 * @internal
 *
 * @link https://www.ibm.com/docs/en/db2/11.5?topic=messages-sql
 */
final class ExceptionConverter implements ExceptionConverterInterface
{
    public function convert(Exception $exception, ?Query $query): DriverException
    {
        return match ($exception->getCode()) {
            -104 => new SyntaxErrorException($exception, $query),
            -203 => new NonUniqueFieldNameException($exception, $query),
            -204 => new TableNotFoundException($exception, $query),
            -206 => new InvalidFieldNameException($exception, $query),
            -407 => new NotNullConstraintViolationException($exception, $query),
            -530, -531, -532, -20356 => new ForeignKeyConstraintViolationException($exception, $query),
            -601 => new TableExistsException($exception, $query),
            -803 => new UniqueConstraintViolationException($exception, $query),
            -1336, -30082 => new ConnectionException($exception, $query),
            default => new DriverException($exception, $query),
        };
    }
}
