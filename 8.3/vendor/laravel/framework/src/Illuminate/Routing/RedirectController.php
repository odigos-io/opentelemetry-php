<?php

namespace Odigos\Illuminate\Routing;

use Odigos\Illuminate\Http\RedirectResponse;
use Odigos\Illuminate\Http\Request;
use Odigos\Illuminate\Support\Collection;
use Odigos\Illuminate\Support\Str;
class RedirectController extends Controller
{
    /**
     * Invoke the controller method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Routing\UrlGenerator  $url
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, UrlGenerator $url)
    {
        $parameters = new Collection($request->route()->parameters());
        $status = $parameters->get('status');
        $destination = $parameters->get('destination');
        $parameters->forget('status')->forget('destination');
        $route = (new Route('GET', $destination, ['as' => 'laravel_route_redirect_destination']))->bind($request);
        $parameters = $parameters->only($route->getCompiled()->getPathVariables())->all();
        $url = $url->toRoute($route, $parameters, \false);
        if (!str_starts_with($destination, '/') && str_starts_with($url, '/')) {
            $url = Str::after($url, '/');
        }
        return new RedirectResponse($url, $status);
    }
}
