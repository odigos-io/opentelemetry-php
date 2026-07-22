<?php

namespace Odigos\Illuminate\Foundation\Testing;

use Odigos\Illuminate\Contracts\Console\Kernel as ConsoleKernel;
trait WithConsoleEvents
{
    /**
     * Register console events.
     *
     * @return void
     */
    protected function setUpWithConsoleEvents()
    {
        $this->app[ConsoleKernel::class]->rerouteSymfonyCommandEvents();
    }
}
