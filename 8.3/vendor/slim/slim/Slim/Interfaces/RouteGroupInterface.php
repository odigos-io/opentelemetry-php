<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim/blob/4.x/LICENSE.md (MIT License)
 */
declare (strict_types=1);
namespace Slim\Interfaces;

use Psr\Http\Server\MiddlewareInterface;
use Slim\MiddlewareDispatcher;
/** @api */
interface RouteGroupInterface
{
    public function collectRoutes(): \Slim\Interfaces\RouteGroupInterface;
    /**
     * Add middleware to the route group
     *
     * @param MiddlewareInterface|string|callable $middleware
     */
    public function add($middleware): \Slim\Interfaces\RouteGroupInterface;
    /**
     * Add middleware to the route group
     */
    public function addMiddleware(MiddlewareInterface $middleware): \Slim\Interfaces\RouteGroupInterface;
    /**
     * Append the group's middleware to the MiddlewareDispatcher
     * @param MiddlewareDispatcher<\Psr\Container\ContainerInterface|null> $dispatcher
     */
    public function appendMiddlewareToDispatcher(MiddlewareDispatcher $dispatcher): \Slim\Interfaces\RouteGroupInterface;
    /**
     * Get the RouteGroup's pattern
     */
    public function getPattern(): string;
}
