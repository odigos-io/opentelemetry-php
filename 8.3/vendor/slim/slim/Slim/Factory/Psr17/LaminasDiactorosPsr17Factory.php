<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim/blob/4.x/LICENSE.md (MIT License)
 */
declare (strict_types=1);
namespace Slim\Factory\Psr17;

class LaminasDiactorosPsr17Factory extends \Slim\Factory\Psr17\Psr17Factory
{
    protected static string $responseFactoryClass = 'Odigos\Laminas\Diactoros\ResponseFactory';
    protected static string $streamFactoryClass = 'Odigos\Laminas\Diactoros\StreamFactory';
    protected static string $serverRequestCreatorClass = 'Odigos\Laminas\Diactoros\ServerRequestFactory';
    protected static string $serverRequestCreatorMethod = 'fromGlobals';
}
