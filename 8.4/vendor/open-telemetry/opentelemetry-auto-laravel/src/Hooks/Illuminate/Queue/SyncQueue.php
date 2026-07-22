<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\Illuminate\Queue;

use Odigos\Illuminate\Queue\SyncQueue as LaravelSyncQueue;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\Context\Context;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\LaravelHook;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\LaravelHookTrait;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\PostHookTrait;
use function OpenTelemetry\Instrumentation\hook;
use OpenTelemetry\SemConv\TraceAttributes;
use Throwable;
class SyncQueue implements LaravelHook
{
    use AttributesBuilder;
    use LaravelHookTrait;
    use PostHookTrait;
    public function instrument(): void
    {
        $this->hookPush();
    }
    /** @psalm-suppress PossiblyUnusedReturnValue */
    protected function hookPush(): bool
    {
        return hook('Illuminate\\Queue\\SyncQueue', 'push', pre: function (object $queue, array $params, string $class, string $function, ?string $filename, ?int $lineno) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $span = $this->instrumentation->tracer()->spanBuilder(vsprintf('%s %s', [$queue->getConnectionName(), 'process']))->setSpanKind(SpanKind::KIND_INTERNAL)->setAttributes([TraceAttributes::CODE_FUNCTION_NAME => sprintf('%s::%s', $class, $function), TraceAttributes::CODE_FILE_PATH => $filename, TraceAttributes::CODE_LINE_NUMBER => $lineno])->startSpan();
            Context::storage()->attach($span->storeInContext(Context::getCurrent()));
        }, post: function (object $queue, array $params, mixed $returnValue, ?Throwable $exception) {
            $this->endSpan($exception);
        });
    }
}
