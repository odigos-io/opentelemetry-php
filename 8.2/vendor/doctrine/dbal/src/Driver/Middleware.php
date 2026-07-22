<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL\Driver;

use Odigos\Doctrine\DBAL\Driver;
interface Middleware
{
    public function wrap(Driver $driver): Driver;
}
