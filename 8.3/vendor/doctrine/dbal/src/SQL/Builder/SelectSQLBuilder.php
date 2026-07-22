<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\SQL\Builder;

use Odigos\Doctrine\DBAL\Exception;
use Odigos\Doctrine\DBAL\Query\SelectQuery;
interface SelectSQLBuilder
{
    /** @throws Exception */
    public function buildSQL(SelectQuery $query): string;
}
