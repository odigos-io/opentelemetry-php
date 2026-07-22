<?php

namespace Odigos\Illuminate\Routing\Contracts;

use Odigos\Illuminate\Routing\Route;
interface CallableDispatcher
{
    /**
     * Dispatch a request to a given callable.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @param  callable  $callable
     * @return mixed
     */
    public function dispatch(Route $route, $callable);
}
