<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Driver\SQLite3;

use Doctrine\DBAL\Driver\Connection as ConnectionInterface;
use Doctrine\DBAL\Driver\Exception\NoIdentityValue;
use SQLite3;
use function assert;
use function sprintf;
final class Connection implements ConnectionInterface
{
    /** @internal The connection can be only instantiated by its driver. */
    public function __construct(private readonly SQLite3 $connection)
    {
    }
    public function prepare(string $sql): \Doctrine\DBAL\Driver\SQLite3\Statement
    {
        try {
            $statement = $this->connection->prepare($sql);
        } catch (\Exception $e) {
            throw \Doctrine\DBAL\Driver\SQLite3\Exception::new($e);
        }
        assert($statement !== \false);
        return new \Doctrine\DBAL\Driver\SQLite3\Statement($this->connection, $statement);
    }
    public function query(string $sql): \Doctrine\DBAL\Driver\SQLite3\Result
    {
        try {
            $result = $this->connection->query($sql);
        } catch (\Exception $e) {
            throw \Doctrine\DBAL\Driver\SQLite3\Exception::new($e);
        }
        assert($result !== \false);
        return new \Doctrine\DBAL\Driver\SQLite3\Result($result, $this->connection->changes());
    }
    public function quote(string $value): string
    {
        return sprintf('\'%s\'', SQLite3::escapeString($value));
    }
    public function exec(string $sql): int
    {
        try {
            $this->connection->exec($sql);
        } catch (\Exception $e) {
            throw \Doctrine\DBAL\Driver\SQLite3\Exception::new($e);
        }
        return $this->connection->changes();
    }
    public function lastInsertId(): int
    {
        $value = $this->connection->lastInsertRowID();
        if ($value === 0) {
            throw NoIdentityValue::new();
        }
        return $value;
    }
    public function beginTransaction(): void
    {
        try {
            $this->connection->exec('BEGIN');
        } catch (\Exception $e) {
            throw \Doctrine\DBAL\Driver\SQLite3\Exception::new($e);
        }
    }
    public function commit(): void
    {
        try {
            $this->connection->exec('COMMIT');
        } catch (\Exception $e) {
            throw \Doctrine\DBAL\Driver\SQLite3\Exception::new($e);
        }
    }
    public function rollBack(): void
    {
        try {
            $this->connection->exec('ROLLBACK');
        } catch (\Exception $e) {
            throw \Doctrine\DBAL\Driver\SQLite3\Exception::new($e);
        }
    }
    public function getNativeConnection(): SQLite3
    {
        return $this->connection;
    }
    public function getServerVersion(): string
    {
        return SQLite3::version()['versionString'];
    }
}
