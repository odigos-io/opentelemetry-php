<?php

namespace Odigos\Illuminate\Queue\Connectors;

use Odigos\Illuminate\Queue\DeferredQueue;
class DeferredConnector implements ConnectorInterface
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
