<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\SQL\Builder;

use Odigos\Doctrine\DBAL\Exception;
use Odigos\Doctrine\DBAL\Query\UnionQuery;
interface UnionSQLBuilder
{
    /** @throws Exception */
    public function buildSQL(UnionQuery $query): string;
}
