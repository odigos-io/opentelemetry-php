<?php

declare (strict_types=1);
namespace Doctrine\DBAL\Query;

/** @internal */
final readonly class Union
{
    public function __construct(public string|\Doctrine\DBAL\Query\QueryBuilder $query, public ?\Doctrine\DBAL\Query\UnionType $type = null)
    {
    }
}
