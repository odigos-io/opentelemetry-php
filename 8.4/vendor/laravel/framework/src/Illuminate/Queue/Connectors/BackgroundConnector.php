<?php

namespace Odigos\Illuminate\Queue\Connectors;

use Odigos\Illuminate\Queue\BackgroundQueue;
class BackgroundConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new BackgroundQueue($config['after_commit'] ?? null);
    }
}
