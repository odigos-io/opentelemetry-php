<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Driver\Middleware;

use Odigos\Doctrine\DBAL\Driver\Result;
use Odigos\Doctrine\DBAL\Driver\Statement;
use Odigos\Doctrine\DBAL\ParameterType;
abstract class AbstractStatementMiddleware implements Statement
{
    public function __construct(private readonly Statement $wrappedStatement)
    {
    }
    public function bindValue(int|string $param, mixed $value, ParameterType $type): void
    {
        $this->wrappedStatement->bindValue($param, $value, $type);
    }
    public function execute(): Result
    {
        return $this->wrappedStatement->execute();
    }
}
