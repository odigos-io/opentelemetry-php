<?php

namespace Illuminate\Queue\Connectors;

use Illuminate\Queue\DeferredQueue;
class DeferredConnector implements \Illuminate\Queue\Connectors\ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new DeferredQueue($config['after_commit'] ?? null);
    }
}
