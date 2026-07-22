<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim/blob/4.x/LICENSE.md (MIT License)
 */
declare (strict_types=1);
namespace Odigos\Slim\Routing;

use Psr\Http\Server\MiddlewareInterface;
use Odigos\Slim\Interfaces\AdvancedCallableResolverInterface;
use Odigos\Slim\Interfaces\CallableResolverInterface;
use Odigos\Slim\Interfaces\RouteCollectorProxyInterface;
use Odigos\Slim\Interfaces\RouteGroupInterface;
use Odigos\Slim\MiddlewareDispatcher;
class RouteGroup implements RouteGroupInterface
{
    /**
     * @var callable|string
     */
    protected $callable;
    protected CallableResolverInterface $callableResolver;
    /**
     * @var RouteCollectorProxyInterface<\Psr\Container\ContainerInterface|null>
     */
    protected RouteCollectorProxyInterface $routeCollectorProxy;
    /**
     * @var MiddlewareInterface[]|string[]|callable[]
     */
    protected array $middleware = [];
    protected string $pattern;
    /**
     * @param callable|string              $callable
     * @param RouteCollectorProxyInterface<\Psr\Container\ContainerInterface|null> $routeCollectorProxy
     */
    public function __construct(string $pattern, $callable, CallableResolverInterface $callableResolver, RouteCollectorProxyInterface $routeCollectorProxy)
    {
        $this->pattern = $pattern;
        $this->callable = $callable;
        $this->callableResolver = $callableResolver;
        $this->routeCollectorProxy = $routeCollectorProxy;
    }
    /**
     * {@inheritdoc}
     */
    public function collectRoutes(): RouteGroupInterface
    {
        if ($this->callableResolver instanceof AdvancedCallableResolverInterface) {
            $callable = $this->callableResolver->resolveRoute($this->callable);
        } else {
            $callable = $this->callableResolver->resolve($this->callable);
        }
        $callable($this->routeCollectorProxy);
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function add($middleware): RouteGroupInterface
    {
        $this->middleware[] = $middleware;
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function addMiddleware(MiddlewareInterface $middleware): RouteGroupInterface
    {
        $this->middleware[] = $middleware;
        return $this;
    }
    /**
     * {@inheritdoc}
     * @param MiddlewareDispatcher<\Psr\Container\ContainerInterface|null> $dispatcher
     */
    public function appendMiddlewareToDispatcher(MiddlewareDispatcher $dispatcher): RouteGroupInterface
    {
        foreach ($this->middleware as $middleware) {
            $dispatcher->add($middleware);
        }
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }
}
