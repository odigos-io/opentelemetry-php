<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Query;

/** @internal */
enum QueryType
{
    case SELECT;
    case DELETE;
    case UPDATE;
    case INSERT;
    case UNION;
}
