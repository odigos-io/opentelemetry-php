<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Portability;

use Doctrine\DBAL\Driver\Connection as ConnectionInterface;
use Doctrine\DBAL\Driver\Middleware\AbstractConnectionMiddleware;
/**
 * Portability wrapper for a Connection.
 */
final class Connection extends AbstractConnectionMiddleware
{
    public const PORTABILITY_ALL = 255;
    public const PORTABILITY_NONE = 0;
    public const PORTABILITY_RTRIM = 1;
    public const PORTABILITY_EMPTY_TO_NULL = 4;
    public const PORTABILITY_FIX_CASE = 8;
    public function __construct(ConnectionInterface $connection, private readonly \Doctrine\DBAL\Portability\Converter $converter)
    {
        parent::__construct($connection);
    }
    public function prepare(string $sql): \Doctrine\DBAL\Portability\Statement
    {
        return new \Doctrine\DBAL\Portability\Statement(parent::prepare($sql), $this->converter);
    }
    public function query(string $sql): \Doctrine\DBAL\Portability\Result
    {
        return new \Doctrine\DBAL\Portability\Result(parent::query($sql), $this->converter);
    }
}
