<?php

namespace Illuminate\Foundation\Exceptions\Whoops;

use Illuminate\Contracts\Foundation\ExceptionRenderer;
use Odigos\Whoops\Run as Whoops;
use function Odigos\tap;
class WhoopsExceptionRenderer implements ExceptionRenderer
{
    /**
     * Renders the given exception as HTML.
     *
     * @param  \Throwable  $throwable
     * @return string
     */
    public function render($throwable)
    {
        return tap(new Whoops(), function ($whoops) {
            $whoops->appendHandler($this->whoopsHandler());
            $whoops->writeToOutput(\false);
            $whoops->allowQuit(\false);
        })->handleException($throwable);
    }
    /**
     * Get the Whoops handler for the application.
     *
     * @return \Whoops\Handler\Handler
     */
    protected function whoopsHandler()
    {
        return (new \Illuminate\Foundation\Exceptions\Whoops\WhoopsHandler())->forDebug();
    }
}
