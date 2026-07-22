<?php

namespace Odigos\Illuminate\Foundation\Exceptions\Renderer;

use Odigos\Illuminate\Contracts\Events\Dispatcher;
use Odigos\Illuminate\Database\Events\QueryExecuted;
use Odigos\Illuminate\Queue\Events\JobProcessed;
use Odigos\Illuminate\Queue\Events\JobProcessing;
use Odigos\Laravel\Octane\Events\RequestReceived;
use Odigos\Laravel\Octane\Events\RequestTerminated;
use Odigos\Laravel\Octane\Events\TaskReceived;
use Odigos\Laravel\Octane\Events\TickReceived;
class Listener
{
    /**
     * The queries that have been executed.
     *
     * @var array<int, array{connectionName: string, time: float, sql: string, bindings: array}>
     */
    protected $queries = [];
    /**
     * Register the appropriate listeners on the given event dispatcher.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function registerListeners(Dispatcher $events)
    {
        $events->listen(QueryExecuted::class, $this->onQueryExecuted(...));
        $events->listen([JobProcessing::class, JobProcessed::class], function () {
            $this->queries = [];
        });
        if (isset($_SERVER['LARAVEL_OCTANE'])) {
            $events->listen([RequestReceived::class, TaskReceived::class, TickReceived::class, RequestTerminated::class], function () {
                $this->queries = [];
            });
        }
    }
    /**
     * Returns the queries that have been executed.
     *
     * @return array<int, array{connectionName: string, time: float, sql: string, bindings: array}>
     */
    public function queries()
    {
        return $this->queries;
    }
    /**
     * Listens for the query executed event.
     *
     * @param  \Illuminate\Database\Events\QueryExecuted  $event
     * @return void
     */
    public function onQueryExecuted(QueryExecuted $event)
    {
        if (count($this->queries) === 101) {
            return;
        }
        $this->queries[] = ['connectionName' => $event->connectionName, 'time' => $event->time, 'sql' => $event->sql, 'bindings' => $event->connection->prepareBindings($event->bindings)];
    }
}
