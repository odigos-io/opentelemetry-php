<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Doctrine;

use Odigos\Doctrine\DBAL\Driver\Result as ResultInterface;
use Odigos\Doctrine\DBAL\Driver\Statement;
use OpenTelemetry\API\Instrumentation\CachedInstrumentation;
use OpenTelemetry\API\Trace\Span;
use OpenTelemetry\API\Trace\SpanBuilderInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\Context\Context;
use function OpenTelemetry\Instrumentation\hook;
use OpenTelemetry\SemConv\TraceAttributes;
use Throwable;
class DoctrineInstrumentation
{
    public const NAME = 'doctrine';
    public static function register(): void
    {
        $instrumentation = new CachedInstrumentation('io.opentelemetry.contrib.php.doctrine');
        $tracker = new DoctrineTracker();
        hook('Doctrine\\DBAL\\Driver', 'connect', pre: static function (object $driver, array $params, string $class, string $function, ?string $filename, ?int $lineno) use ($instrumentation) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $builder = self::makeBuilder($instrumentation, 'Odigos\Doctrine\DBAL\Driver::connect', $function, $class, $filename, $lineno)->setSpanKind(SpanKind::KIND_CLIENT)->setAttribute(TraceAttributes::SERVER_ADDRESS, AttributesResolver::get(TraceAttributes::SERVER_ADDRESS, func_get_args()))->setAttribute(TraceAttributes::SERVER_PORT, AttributesResolver::get(TraceAttributes::SERVER_PORT, func_get_args()))->setAttribute(TraceAttributes::DB_SYSTEM_NAME, AttributesResolver::get(TraceAttributes::DB_SYSTEM_NAME, func_get_args()))->setAttribute(TraceAttributes::DB_NAMESPACE, AttributesResolver::get(TraceAttributes::DB_NAMESPACE, func_get_args()));
            $parent = Context::getCurrent();
            $span = $builder->startSpan();
            Context::storage()->attach($span->storeInContext($parent));
        }, post: static function (object $driver, array $params, ?object $connection, ?Throwable $exception) {
            self::end($exception);
        });
        hook('Doctrine\\DBAL\\Driver\\Connection', 'query', pre: static function (object $connection, array $params, string $class, string $function, ?string $filename, ?int $lineno) use ($instrumentation) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $builder = self::makeBuilder($instrumentation, AttributesResolver::getDbQuerySummary($params), $function, $class, $filename, $lineno)->setSpanKind(SpanKind::KIND_CLIENT);
            $builder->setAttribute(TraceAttributes::DB_QUERY_TEXT, AttributesResolver::get(TraceAttributes::DB_QUERY_TEXT, func_get_args()));
            $builder->setAttribute(TraceAttributes::DB_OPERATION_NAME, AttributesResolver::getDbOperationName($params));
            $builder->setAttribute(TraceAttributes::DB_COLLECTION_NAME, AttributesResolver::getTarget($params));
            $parent = Context::getCurrent();
            $span = $builder->startSpan();
            Context::storage()->attach($span->storeInContext($parent));
        }, post: static function (object $connection, array $params, mixed $statement, ?Throwable $exception) {
            self::end($exception);
        });
        hook('Doctrine\\DBAL\\Driver\\Connection', 'exec', pre: static function (object $connection, array $params, string $class, string $function, ?string $filename, ?int $lineno) use ($instrumentation) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $builder = self::makeBuilder($instrumentation, AttributesResolver::getDbQuerySummary($params), $function, $class, $filename, $lineno)->setSpanKind(SpanKind::KIND_CLIENT)->setAttribute(TraceAttributes::DB_QUERY_TEXT, AttributesResolver::get(TraceAttributes::DB_QUERY_TEXT, func_get_args()))->setAttribute(TraceAttributes::DB_OPERATION_NAME, AttributesResolver::getDbOperationName($params))->setAttribute(TraceAttributes::DB_COLLECTION_NAME, AttributesResolver::getTarget($params));
            $parent = Context::getCurrent();
            $span = $builder->startSpan();
            Context::storage()->attach($span->storeInContext($parent));
        }, post: static function (object $connection, array $params, mixed $statement, ?Throwable $exception) {
            self::end($exception);
        });
        hook('Doctrine\\DBAL\\Driver\\Connection', 'prepare', pre: static function (object $connection, array $params, string $class, string $function, ?string $filename, ?int $lineno) use ($instrumentation) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $builder = self::makeBuilder($instrumentation, AttributesResolver::getDbQuerySummary($params), $function, $class, $filename, $lineno)->setSpanKind(SpanKind::KIND_CLIENT)->setAttribute(TraceAttributes::DB_QUERY_TEXT, AttributesResolver::get(TraceAttributes::DB_QUERY_TEXT, func_get_args()))->setAttribute(TraceAttributes::DB_OPERATION_NAME, 'prepare');
            $parent = Context::getCurrent();
            $span = $builder->startSpan();
            Context::storage()->attach($span->storeInContext($parent));
        }, post: static function (object $connection, array $params, ?object $statement, ?Throwable $exception) use ($tracker) {
            if ($statement) {
                $scope = Context::storage()->scope();
                $context = $scope?->context();
                if ($context) {
                    $span = Span::fromContext($context);
                    $tracker->trackStatement($statement, $span->getContext());
                }
            }
            self::end($exception);
        });
        hook('Doctrine\\DBAL\\Driver\\Connection', 'beginTransaction', pre: static function (object $connection, array $params, string $class, string $function, ?string $filename, ?int $lineno) use ($instrumentation) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $builder = self::makeBuilder($instrumentation, 'Doctrine::beginTransaction', $function, $class, $filename, $lineno)->setSpanKind(SpanKind::KIND_CLIENT)->setAttribute(TraceAttributes::DB_OPERATION_NAME, 'begin');
            $parent = Context::getCurrent();
            $span = $builder->startSpan();
            Context::storage()->attach($span->storeInContext($parent));
        }, post: static function (object $connection, array $params, mixed $statement, ?Throwable $exception) {
            self::end($exception);
        });
        hook('Doctrine\\DBAL\\Driver\\Connection', 'commit', pre: static function (object $connection, array $params, string $class, string $function, ?string $filename, ?int $lineno) use ($instrumentation) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $builder = self::makeBuilder($instrumentation, 'Doctrine::commit', $function, $class, $filename, $lineno)->setSpanKind(SpanKind::KIND_CLIENT)->setAttribute(TraceAttributes::DB_OPERATION_NAME, 'commit');
            $parent = Context::getCurrent();
            $span = $builder->startSpan();
            Context::storage()->attach($span->storeInContext($parent));
        }, post: static function (object $connection, array $params, mixed $statement, ?Throwable $exception) {
            self::end($exception);
        });
        hook('Doctrine\\DBAL\\Driver\\Connection', 'rollBack', pre: static function (object $connection, array $params, string $class, string $function, ?string $filename, ?int $lineno) use ($instrumentation) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $builder = self::makeBuilder($instrumentation, 'Doctrine::rollBack', $function, $class, $filename, $lineno)->setSpanKind(SpanKind::KIND_CLIENT)->setAttribute(TraceAttributes::DB_OPERATION_NAME, 'rollback');
            $parent = Context::getCurrent();
            $span = $builder->startSpan();
            Context::storage()->attach($span->storeInContext($parent));
        }, post: static function (object $connection, array $params, mixed $statement, ?Throwable $exception) {
            self::end($exception);
        });
        hook('Doctrine\\DBAL\\Driver\\Statement', 'execute', pre: static function (object $statement, array $params, string $class, string $function, ?string $filename, ?int $lineno) use ($instrumentation, $tracker) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $builder = self::makeBuilder($instrumentation, 'Doctrine::execute', $function, $class, $filename, $lineno)->setSpanKind(SpanKind::KIND_CLIENT)->setAttribute(TraceAttributes::DB_OPERATION_NAME, 'execute');
            if ($ctx = $tracker->getSpanContextForStatement($statement)) {
                $builder->addLink($ctx);
            }
            $parent = Context::getCurrent();
            $span = $builder->startSpan();
            Context::storage()->attach($span->storeInContext($parent));
        }, post: static function (object $statement, array $params, ?object $result, ?Throwable $exception) {
            self::end($exception);
        });
    }
    private static function makeBuilder(CachedInstrumentation $instrumentation, string $name, string $function, string $class, ?string $filename, ?int $lineno): SpanBuilderInterface
    {
        /** @psalm-suppress ArgumentTypeCoercion */
        return $instrumentation->tracer()->spanBuilder($name)->setAttribute(TraceAttributes::CODE_FUNCTION_NAME, sprintf('%s::%s', $class, $function))->setAttribute(TraceAttributes::CODE_FILE_PATH, $filename)->setAttribute(TraceAttributes::CODE_LINE_NUMBER, $lineno);
    }
    private static function end(?Throwable $exception): void
    {
        $scope = Context::storage()->scope();
        if (!$scope) {
            return;
        }
        $scope->detach();
        $span = Span::fromContext($scope->context());
        if ($exception) {
            $span->recordException($exception);
            $span->setStatus(StatusCode::STATUS_ERROR, $exception->getMessage());
        }
        $span->end();
    }
}
