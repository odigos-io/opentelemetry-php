<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Watchers\RedisCommand;

use Odigos\Illuminate\Contracts\Foundation\Application;
use Odigos\Illuminate\Redis\Connections\Connection;
use Odigos\Illuminate\Redis\Connections\PhpRedisConnection;
use Odigos\Illuminate\Redis\Connections\PredisConnection;
use Odigos\Illuminate\Redis\Events\CommandExecuted;
use OpenTelemetry\API\Instrumentation\CachedInstrumentation;
use OpenTelemetry\API\Trace\SpanKind;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Watchers\Watcher;
use OpenTelemetry\SemConv\TraceAttributes;
use OpenTelemetry\SemConv\TraceAttributeValues;
use Throwable;
/**
 * Watch the Redis Command event
 *
 * Call facade `Redis::enableEvents()` before using this watcher
 */
class RedisCommandWatcher extends Watcher
{
    public function __construct(private CachedInstrumentation $instrumentation)
    {
    }
    /** @psalm-suppress UndefinedInterfaceMethod */
    public function register(object $app): void
    {
        /** @phan-suppress-next-line PhanTypeArraySuspicious */
        $app['events']->listen(CommandExecuted::class, [$this, 'recordRedisCommand']);
    }
    /**
     * Record a Redis command.
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function recordRedisCommand(object $event): void
    {
        $nowInNs = (int) (microtime(\true) * 1000000000.0);
        $operationName = strtoupper($event->command);
        /** @psalm-suppress ArgumentTypeCoercion */
        $span = $this->instrumentation->tracer()->spanBuilder($operationName)->setSpanKind(SpanKind::KIND_CLIENT)->setStartTimestamp($this->calculateQueryStartTime($nowInNs, $event->time))->startSpan();
        // See https://opentelemetry.io/docs/specs/semconv/database/redis/
        $attributes = [TraceAttributes::DB_SYSTEM_NAME => TraceAttributeValues::DB_SYSTEM_REDIS, TraceAttributes::DB_NAMESPACE => $this->fetchDbIndex($event->connection), TraceAttributes::DB_OPERATION_NAME => $operationName, TraceAttributes::DB_QUERY_TEXT => Serializer::serializeCommand($event->command, $event->parameters), TraceAttributes::SERVER_ADDRESS => $this->fetchDbHost($event->connection)];
        /** @psalm-suppress PossiblyInvalidArgument */
        $span->setAttributes($attributes);
        $span->end($nowInNs);
    }
    private function calculateQueryStartTime(int $nowInNs, float $queryTimeMs): int
    {
        return (int) ($nowInNs - $queryTimeMs * 1000000.0);
    }
    private function fetchDbIndex(object $connection): ?int
    {
        try {
            if (is_a($connection, 'Illuminate\\Redis\\Connections\\PhpRedisConnection')) {
                return $connection->client()->getDbNum();
            } elseif (is_a($connection, 'Illuminate\\Redis\\Connections\\PredisConnection')) {
                /** @psalm-suppress PossiblyUndefinedMethod */
                return $connection->client()->getConnection()->getParameters()->database;
            }
            return null;
        } catch (Throwable $e) {
            return null;
        }
    }
    private function fetchDbHost(object $connection): ?string
    {
        try {
            if (is_a($connection, 'Illuminate\\Redis\\Connections\\PhpRedisConnection')) {
                return $connection->client()->getHost();
            } elseif (is_a($connection, 'Illuminate\\Redis\\Connections\\PredisConnection')) {
                /** @psalm-suppress PossiblyUndefinedMethod */
                return $connection->client()->getConnection()->getParameters()->host;
            }
            return null;
        } catch (Throwable $e) {
            return null;
        }
    }
}
