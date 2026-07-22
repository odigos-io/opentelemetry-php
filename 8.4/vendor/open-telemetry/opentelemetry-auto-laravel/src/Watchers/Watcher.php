<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Watchers;

use Odigos\Illuminate\Contracts\Foundation\Application;
abstract class Watcher
{
    /**
     * Register the watcher.
     */
    abstract public function register(object $app): void;
}
