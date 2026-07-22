<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Watchers;

use Odigos\Illuminate\Contracts\Foundation\Application;
use Odigos\Illuminate\Database\Events\QueryExecuted;
use Odigos\Illuminate\Support\Str;
use OpenTelemetry\API\Instrumentation\CachedInstrumentation;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\SemConv\TraceAttributes;
class QueryWatcher extends Watcher
{
    public function __construct(private CachedInstrumentation $instrumentation)
    {
    }
    /** @psalm-suppress UndefinedInterfaceMethod */
    public function register(object $app): void
    {
        /** @phan-suppress-next-line PhanTypeArraySuspicious */
        $app['events']->listen(QueryExecuted::class, [$this, 'recordQuery']);
    }
    /**
     * Record a query.
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function recordQuery(object $query): void
    {
        $nowInNs = (int) (microtime(\true) * 1000000000.0);
        $operationName = Str::upper(Str::before($query->sql, ' '));
        if (!in_array($operationName, ['SELECT', 'INSERT', 'UPDATE', 'DELETE'])) {
            $operationName = null;
        }
        /** @psalm-suppress ArgumentTypeCoercion */
        $span = $this->instrumentation->tracer()->spanBuilder('sql ' . $operationName)->setSpanKind(SpanKind::KIND_CLIENT)->setStartTimestamp($this->calculateQueryStartTime($nowInNs, $query->time))->startSpan();
        $attributes = [TraceAttributes::DB_SYSTEM_NAME => $query->connection->getDriverName(), TraceAttributes::DB_NAMESPACE => $query->connection->getDatabaseName(), TraceAttributes::DB_OPERATION_NAME => $operationName];
        $attributes[TraceAttributes::DB_QUERY_TEXT] = $query->sql;
        /** @psalm-suppress PossiblyInvalidArgument */
        $span->setAttributes($attributes);
        $span->end($nowInNs);
    }
    private function calculateQueryStartTime(int $nowInNs, float $queryTimeMs): int
    {
        return (int) ($nowInNs - $queryTimeMs * 1000000.0);
    }
}
