<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Portability;

use Odigos\Doctrine\DBAL\ColumnCase;
use Odigos\Doctrine\DBAL\Driver as DriverInterface;
use Odigos\Doctrine\DBAL\Driver\Middleware as MiddlewareInterface;
final class Middleware implements MiddlewareInterface
{
    public function __construct(private readonly int $mode, private readonly ?ColumnCase $case)
    {
    }
    public function wrap(DriverInterface $driver): DriverInterface
    {
        if ($this->mode !== 0) {
            return new Driver($driver, $this->mode, $this->case);
        }
        return $driver;
    }
}
