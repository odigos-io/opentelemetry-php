<?php

namespace Odigos\Illuminate\Foundation\Http\Middleware;

use Closure;
use Odigos\Illuminate\Container\Container;
use Odigos\Illuminate\Http\Request;
use Odigos\Illuminate\Support\Defer\DeferredCallbackCollection;
use Odigos\Symfony\Component\HttpFoundation\Response;
class InvokeDeferredCallbacks
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
    /**
     * Invoke the deferred callbacks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return void
     */
    public function terminate(Request $request, Response $response)
    {
        Container::getInstance()->make(DeferredCallbackCollection::class)->invokeWhen(fn($callback) => $response->getStatusCode() < 400 || $callback->always);
    }
}
