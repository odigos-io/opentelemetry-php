<?php

namespace Illuminate\Queue\Connectors;

use Illuminate\Queue\NullQueue;
class NullConnector implements \Illuminate\Queue\Connectors\ConnectorInterface
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
