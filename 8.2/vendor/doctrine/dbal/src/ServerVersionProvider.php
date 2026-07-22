<?php

declare (strict_types=1);
namespace Odigos\Doctrine\DBAL;

interface ServerVersionProvider
{
    /**
     * Returns the database server version
     */
    public function getServerVersion(): string;
}
