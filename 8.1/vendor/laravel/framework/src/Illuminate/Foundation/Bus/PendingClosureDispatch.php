<?php

namespace Illuminate\Foundation\Bus;

use Closure;
class PendingClosureDispatch extends \Illuminate\Foundation\Bus\PendingDispatch
{
    /**
     * Add a callback to be executed if the job fails.
     *
     * @param  \Closure  $callback
     * @return $this
     */
    public function catch(Closure $callback)
    {
        $this->job->onFailure($callback);
        return $this;
    }
}
