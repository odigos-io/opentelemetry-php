<?php

namespace Illuminate\Events;

use Closure;
if (!function_exists('Illuminate\Events\queueable')) {
    /**
     * Create a new queued Closure event listener.
     *
     * @param  \Closure  $closure
     */
    function queueable(Closure $closure): \Illuminate\Events\QueuedClosure
    {
        return new \Illuminate\Events\QueuedClosure($closure);
    }
}
