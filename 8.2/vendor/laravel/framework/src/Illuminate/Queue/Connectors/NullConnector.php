<?php

namespace Odigos\Illuminate\Queue\Connectors;

use Odigos\Illuminate\Queue\NullQueue;
class NullConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new NullQueue();
    }
}
