<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Exception;

use Odigos\Doctrine\DBAL\Exception;
use LogicException;
abstract class InvalidColumnType extends LogicException implements Exception
{
}
