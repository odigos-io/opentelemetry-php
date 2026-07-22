<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Exception;

use Odigos\Doctrine\DBAL\Exception;
/**
 * Exception to be thrown when invalid arguments are passed to any DBAL API
 */
class InvalidArgumentException extends \InvalidArgumentException implements Exception
{
}
