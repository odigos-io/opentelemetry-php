<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Testing\Responses\Concerns;

use Odigos\Http\Discovery\Psr17FactoryDiscovery;
use Odigos\OpenAI\Responses\StreamResponse;
trait FakeableForStreamedResponse
{
    /**
     * @param  resource  $resource
     */
    public static function fake($resource = null): StreamResponse
    {
        if ($resource === null) {
            $filename = str_replace(['OpenAI\Responses', '\\'], [__DIR__ . '/../Fixtures/', '/'], static::class) . 'Fixture.txt';
            $resource = fopen($filename, 'r');
        }
        $stream = Psr17FactoryDiscovery::findStreamFactory()->createStreamFromResource($resource);
        $response = Psr17FactoryDiscovery::findResponseFactory()->createResponse()->withBody($stream);
        return new StreamResponse(static::class, $response);
    }
}
