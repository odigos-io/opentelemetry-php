<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Exception;

/**
 * Exception for a unique constraint violation detected in the driver.
 */
class UniqueConstraintViolationException extends ConstraintViolationException
{
}
