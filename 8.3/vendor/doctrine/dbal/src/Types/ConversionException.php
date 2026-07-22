<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Types;

use Odigos\Doctrine\DBAL\Exception;
/**
 * Conversion Exception is thrown when the database to PHP conversion fails.
 */
class ConversionException extends \Exception implements Exception
{
}
