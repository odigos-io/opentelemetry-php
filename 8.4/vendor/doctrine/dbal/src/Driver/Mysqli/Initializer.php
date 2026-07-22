<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Driver\Mysqli;

use Odigos\Doctrine\DBAL\Driver\Exception;
use mysqli;
interface Initializer
{
    /** @throws Exception */
    public function initialize(mysqli $connection): void;
}
