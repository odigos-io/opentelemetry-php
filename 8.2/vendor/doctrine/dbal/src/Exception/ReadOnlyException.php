<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Exception;

/**
 * Exception for a write operation attempt on a read-only database element detected in the driver.
 */
class ReadOnlyException extends ServerException
{
}
