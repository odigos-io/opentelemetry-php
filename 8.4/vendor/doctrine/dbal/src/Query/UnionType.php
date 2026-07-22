<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Query;

enum UnionType
{
    case ALL;
    case DISTINCT;
}
