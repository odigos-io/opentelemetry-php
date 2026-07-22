<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\Illuminate\Console;

use Odigos\Illuminate\Console\Command as IlluminateCommand;
use OpenTelemetry\API\Trace\Span;
use OpenTelemetry\Context\Context;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\LaravelHook;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\LaravelHookTrait;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\PostHookTrait;
use function OpenTelemetry\Instrumentation\hook;
use OpenTelemetry\SemConv\TraceAttributes;
use Throwable;
class Command implements LaravelHook
{
    use LaravelHookTrait;
    use PostHookTrait;
    public function instrument(): void
    {
        $this->hookExecute();
    }
    /** @psalm-suppress PossiblyUnusedReturnValue  */
    protected function hookExecute(): bool
    {
        return hook('Illuminate\\Console\\Command', 'execute', pre: function (object $command, array $params, string $class, string $function, ?string $filename, ?int $lineno) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $builder = $this->instrumentation->tracer()->spanBuilder(sprintf('Command %s', $command->getName() ?: 'unknown'))->setAttribute(TraceAttributes::CODE_FUNCTION_NAME, sprintf('%s::%s', $class, $function))->setAttribute(TraceAttributes::CODE_FILE_PATH, $filename)->setAttribute(TraceAttributes::CODE_LINE_NUMBER, $lineno);
            $parent = Context::getCurrent();
            $span = $builder->startSpan();
            Context::storage()->attach($span->storeInContext($parent));
            return $params;
        }, post: function (object $command, array $params, ?int $exitCode, ?Throwable $exception) {
            $scope = Context::storage()->scope();
            if (!$scope) {
                return;
            }
            $span = Span::fromContext($scope->context());
            $span->addEvent('command finished', ['exit-code' => $exitCode]);
            $this->endSpan($exception);
        });
    }
}
