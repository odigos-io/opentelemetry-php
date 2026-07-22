<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\Illuminate\Foundation\Console;

use Odigos\Illuminate\Foundation\Console\ServeCommand as FoundationServeCommand;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\LaravelHook;
use Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Hooks\LaravelHookTrait;
use function OpenTelemetry\Instrumentation\hook;
/**
 * Instrument Laravel's local PHP development server.
 */
class ServeCommand implements LaravelHook
{
    use LaravelHookTrait;
    public function instrument(): void
    {
        /** @psalm-suppress UnusedFunctionCall */
        hook('Illuminate\\Foundation\\Console\\ServeCommand', 'handle', pre: static function (object $_serveCommand, array $_params, string $_class, string $_function, ?string $_filename, ?int $_lineno) {
            if (!property_exists(FoundationServeCommand::class, 'passthroughVariables')) {
                return;
            }
            foreach ($_ENV as $key => $_value) {
                if (str_starts_with($key, 'OTEL_') && !in_array($key, FoundationServeCommand::$passthroughVariables)) {
                    FoundationServeCommand::$passthroughVariables[] = $key;
                }
            }
        });
    }
}
