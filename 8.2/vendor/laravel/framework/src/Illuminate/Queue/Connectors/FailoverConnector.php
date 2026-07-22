<?php

namespace Odigos\Illuminate\Queue\Connectors;

use Odigos\Illuminate\Contracts\Events\Dispatcher;
use Odigos\Illuminate\Queue\FailoverQueue;
use Odigos\Illuminate\Queue\QueueManager;
class FailoverConnector implements ConnectorInterface
{
    /**
     * Create a new connector instance.
     */
    public function __construct(protected QueueManager $manager, protected Dispatcher $events)
    {
    }
    /**
     * Establish a queue connection.
     *
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new FailoverQueue($this->manager, $this->events, $config['connections']);
    }
}
