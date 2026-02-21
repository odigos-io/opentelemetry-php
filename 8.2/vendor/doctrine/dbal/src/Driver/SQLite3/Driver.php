<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Driver\SQLite3;

use Doctrine\DBAL\Driver\AbstractSQLiteDriver;
use SensitiveParameter;
use SQLite3;
final class Driver extends AbstractSQLiteDriver
{
    /**
     * {@inheritDoc}
     */
    public function connect(#[SensitiveParameter] array $params): \Doctrine\DBAL\Driver\SQLite3\Connection
    {
        $isMemory = $params['memory'] ?? \false;
        if (isset($params['path'])) {
            if ($isMemory) {
                throw new \Doctrine\DBAL\Driver\SQLite3\Exception('Invalid connection settings: specifying both parameters "path" and "memory" is ambiguous.');
            }
            $filename = $params['path'];
        } elseif ($isMemory) {
            $filename = ':memory:';
        } else {
            throw new \Doctrine\DBAL\Driver\SQLite3\Exception('Invalid connection settings: specify either the "path" or the "memory" parameter for SQLite3.');
        }
        try {
            $connection = new SQLite3($filename);
        } catch (\Exception $e) {
            throw \Doctrine\DBAL\Driver\SQLite3\Exception::new($e);
        }
        $connection->enableExceptions(\true);
        return new \Doctrine\DBAL\Driver\SQLite3\Connection($connection);
    }
}
