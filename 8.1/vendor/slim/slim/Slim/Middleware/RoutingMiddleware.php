<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim/blob/4.x/LICENSE.md (MIT License)
 */
declare (strict_types=1);
namespace Odigos\Slim\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;
use Odigos\Slim\Exception\HttpMethodNotAllowedException;
use Odigos\Slim\Exception\HttpNotFoundException;
use Odigos\Slim\Interfaces\RouteParserInterface;
use Odigos\Slim\Interfaces\RouteResolverInterface;
use Odigos\Slim\Routing\RouteContext;
use Odigos\Slim\Routing\RoutingResults;
class RoutingMiddleware implements MiddlewareInterface
{
    protected RouteResolverInterface $routeResolver;
    protected RouteParserInterface $routeParser;
    public function __construct(RouteResolverInterface $routeResolver, RouteParserInterface $routeParser)
    {
        $this->routeResolver = $routeResolver;
        $this->routeParser = $routeParser;
    }
    /**
     * @throws HttpNotFoundException
     * @throws HttpMethodNotAllowedException
     * @throws RuntimeException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $this->performRouting($request);
        return $handler->handle($request);
    }
    /**
     * Perform routing
     *
     * @param  ServerRequestInterface $request PSR7 Server Request
     *
     * @throws HttpNotFoundException
     * @throws HttpMethodNotAllowedException
     * @throws RuntimeException
     */
    public function performRouting(ServerRequestInterface $request): ServerRequestInterface
    {
        $request = $request->withAttribute(RouteContext::ROUTE_PARSER, $this->routeParser);
        $routingResults = $this->resolveRoutingResultsFromRequest($request);
        $routeStatus = $routingResults->getRouteStatus();
        $request = $request->withAttribute(RouteContext::ROUTING_RESULTS, $routingResults);
        switch ($routeStatus) {
            case RoutingResults::FOUND:
                $routeArguments = $routingResults->getRouteArguments();
                $routeIdentifier = $routingResults->getRouteIdentifier() ?? '';
                $route = $this->routeResolver->resolveRoute($routeIdentifier)->prepare($routeArguments);
                return $request->withAttribute(RouteContext::ROUTE, $route);
            case RoutingResults::NOT_FOUND:
                throw new HttpNotFoundException($request);
            case RoutingResults::METHOD_NOT_ALLOWED:
                $exception = new HttpMethodNotAllowedException($request);
                $exception->setAllowedMethods($routingResults->getAllowedMethods());
                throw $exception;
            default:
                throw new RuntimeException('An unexpected error occurred while performing routing.');
        }
    }
    /**
     * Resolves the route from the given request
     */
    protected function resolveRoutingResultsFromRequest(ServerRequestInterface $request): RoutingResults
    {
        return $this->routeResolver->computeRoutingResults($request->getUri()->getPath(), $request->getMethod());
    }
}
