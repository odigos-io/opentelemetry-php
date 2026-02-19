<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim/blob/4.x/LICENSE.md (MIT License)
 */
declare (strict_types=1);
namespace Slim\Interfaces;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\UriInterface;
/**
 * @api
 * @template TContainerInterface of (ContainerInterface|null)
 */
interface RouteCollectorProxyInterface
{
    public function getResponseFactory(): ResponseFactoryInterface;
    public function getCallableResolver(): \Slim\Interfaces\CallableResolverInterface;
    /**
     * @return TContainerInterface
     */
    public function getContainer(): ?ContainerInterface;
    public function getRouteCollector(): \Slim\Interfaces\RouteCollectorInterface;
    /**
     * Get the RouteCollectorProxy's base path
     */
    public function getBasePath(): string;
    /**
     * Set the RouteCollectorProxy's base path
     * @return RouteCollectorProxyInterface<TContainerInterface>
     */
    public function setBasePath(string $basePath): \Slim\Interfaces\RouteCollectorProxyInterface;
    /**
     * Add GET route
     *
     * @param string $pattern The route URI pattern
     * @param callable|array{class-string, string}|string $callable The route callback routine
     */
    public function get(string $pattern, $callable): \Slim\Interfaces\RouteInterface;
    /**
     * Add POST route
     *
     * @param string $pattern The route URI pattern
     * @param callable|array{class-string, string}|string $callable The route callback routine
     */
    public function post(string $pattern, $callable): \Slim\Interfaces\RouteInterface;
    /**
     * Add PUT route
     *
     * @param string $pattern The route URI pattern
     * @param callable|array{class-string, string}|string $callable The route callback routine
     */
    public function put(string $pattern, $callable): \Slim\Interfaces\RouteInterface;
    /**
     * Add PATCH route
     *
     * @param string $pattern The route URI pattern
     * @param callable|array{class-string, string}|string $callable The route callback routine
     */
    public function patch(string $pattern, $callable): \Slim\Interfaces\RouteInterface;
    /**
     * Add DELETE route
     *
     * @param string $pattern The route URI pattern
     * @param callable|array{class-string, string}|string $callable The route callback routine
     */
    public function delete(string $pattern, $callable): \Slim\Interfaces\RouteInterface;
    /**
     * Add OPTIONS route
     *
     * @param string $pattern The route URI pattern
     * @param callable|array{class-string, string}|string $callable The route callback routine
     */
    public function options(string $pattern, $callable): \Slim\Interfaces\RouteInterface;
    /**
     * Add route for any HTTP method
     *
     * @param string $pattern The route URI pattern
     * @param callable|array{class-string, string}|string $callable The route callback routine
     */
    public function any(string $pattern, $callable): \Slim\Interfaces\RouteInterface;
    /**
     * Add route with multiple methods
     *
     * @param string[] $methods Numeric array of HTTP method names
     * @param string $pattern The route URI pattern
     * @param callable|array{class-string, string}|string $callable The route callback routine
     */
    public function map(array $methods, string $pattern, $callable): \Slim\Interfaces\RouteInterface;
    /**
     * Route Groups
     *
     * This method accepts a route pattern and a callback. All route
     * declarations in the callback will be prepended by the group(s)
     * that it is in.
     * @param string|callable $callable
     */
    public function group(string $pattern, $callable): \Slim\Interfaces\RouteGroupInterface;
    /**
     * Add a route that sends an HTTP redirect
     *
     * @param string|UriInterface $to
     */
    public function redirect(string $from, $to, int $status = 302): \Slim\Interfaces\RouteInterface;
}
