<?php

declare (strict_types=1);
namespace Odigos\Termwind\Laravel;

use Odigos\Illuminate\Console\OutputStyle;
use Odigos\Illuminate\Support\ServiceProvider;
use Odigos\Termwind\Termwind;
final class TermwindServiceProvider extends ServiceProvider
{
    /**
     * Sets the correct renderer to be used.
     */
    public function register(): void
    {
        $this->app->resolving(OutputStyle::class, function ($style): void {
            Termwind::renderUsing($style->getOutput());
        });
    }
}
