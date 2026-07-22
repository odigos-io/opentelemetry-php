<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim/blob/4.x/LICENSE.md (MIT License)
 */
declare (strict_types=1);
namespace Odigos\Slim\Factory\Psr17;

class GuzzlePsr17Factory extends Psr17Factory
{
    protected static string $responseFactoryClass = 'Odigos\GuzzleHttp\Psr7\HttpFactory';
    protected static string $streamFactoryClass = 'Odigos\GuzzleHttp\Psr7\HttpFactory';
    protected static string $serverRequestCreatorClass = 'Odigos\GuzzleHttp\Psr7\ServerRequest';
    protected static string $serverRequestCreatorMethod = 'fromGlobals';
}
