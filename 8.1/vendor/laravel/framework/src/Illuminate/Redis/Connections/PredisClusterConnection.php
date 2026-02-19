<?php

namespace Illuminate\Redis\Connections;

use Odigos\Predis\Command\Redis\FLUSHDB;
use Odigos\Predis\Command\ServerFlushDatabase;
class PredisClusterConnection extends \Illuminate\Redis\Connections\PredisConnection
{
    /**
     * Flush the selected Redis database on all cluster nodes.
     *
     * @return void
     */
    public function flushdb()
    {
        $command = class_exists(ServerFlushDatabase::class) ? ServerFlushDatabase::class : FLUSHDB::class;
        foreach ($this->client as $node) {
            $node->executeCommand(tap(new $command())->setArguments(func_get_args()));
        }
    }
}
