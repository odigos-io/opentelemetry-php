<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Driver\API\SQLite;

use Odigos\Doctrine\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Odigos\Doctrine\DBAL\Driver\Exception;
use Odigos\Doctrine\DBAL\Exception\ConnectionException;
use Odigos\Doctrine\DBAL\Exception\DriverException;
use Odigos\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Odigos\Doctrine\DBAL\Exception\InvalidFieldNameException;
use Odigos\Doctrine\DBAL\Exception\LockWaitTimeoutException;
use Odigos\Doctrine\DBAL\Exception\NonUniqueFieldNameException;
use Odigos\Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Odigos\Doctrine\DBAL\Exception\ReadOnlyException;
use Odigos\Doctrine\DBAL\Exception\SyntaxErrorException;
use Odigos\Doctrine\DBAL\Exception\TableExistsException;
use Odigos\Doctrine\DBAL\Exception\TableNotFoundException;
use Odigos\Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Odigos\Doctrine\DBAL\Query;
use function str_contains;
/** @internal */
final class ExceptionConverter implements ExceptionConverterInterface
{
    /** @link http://www.sqlite.org/c3ref/c_abort.html */
    public function convert(Exception $exception, ?Query $query): DriverException
    {
        if (str_contains($exception->getMessage(), 'database is locked')) {
            return new LockWaitTimeoutException($exception, $query);
        }
        if (str_contains($exception->getMessage(), 'must be unique') || str_contains($exception->getMessage(), 'is not unique') || str_contains($exception->getMessage(), 'are not unique') || str_contains($exception->getMessage(), 'UNIQUE constraint failed')) {
            return new UniqueConstraintViolationException($exception, $query);
        }
        if (str_contains($exception->getMessage(), 'may not be NULL') || str_contains($exception->getMessage(), 'NOT NULL constraint failed')) {
            return new NotNullConstraintViolationException($exception, $query);
        }
        if (str_contains($exception->getMessage(), 'no such table:')) {
            return new TableNotFoundException($exception, $query);
        }
        if (str_contains($exception->getMessage(), 'already exists')) {
            return new TableExistsException($exception, $query);
        }
        if (str_contains($exception->getMessage(), 'has no column named')) {
            return new InvalidFieldNameException($exception, $query);
        }
        if (str_contains($exception->getMessage(), 'ambiguous column name')) {
            return new NonUniqueFieldNameException($exception, $query);
        }
        if (str_contains($exception->getMessage(), 'syntax error')) {
            return new SyntaxErrorException($exception, $query);
        }
        if (str_contains($exception->getMessage(), 'attempt to write a readonly database')) {
            return new ReadOnlyException($exception, $query);
        }
        if (str_contains($exception->getMessage(), 'unable to open database file')) {
            return new ConnectionException($exception, $query);
        }
        if (str_contains($exception->getMessage(), 'FOREIGN KEY constraint failed')) {
            return new ForeignKeyConstraintViolationException($exception, $query);
        }
        return new DriverException($exception, $query);
    }
}
