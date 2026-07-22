<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim/blob/4.x/LICENSE.md (MIT License)
 */
declare (strict_types=1);
namespace Odigos\Slim\Factory\Psr17;

class HttpSoftPsr17Factory extends Psr17Factory
{
    protected static string $responseFactoryClass = 'Odigos\HttpSoft\Message\ResponseFactory';
    protected static string $streamFactoryClass = 'Odigos\HttpSoft\Message\StreamFactory';
    protected static string $serverRequestCreatorClass = 'Odigos\HttpSoft\ServerRequest\ServerRequestCreator';
    protected static string $serverRequestCreatorMethod = 'createFromGlobals';
}
