<?php

namespace Odigos\Http\Discovery\Strategy;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
/**
 * @internal
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 *
 * Don't miss updating src/Composer/Plugin.php when adding a new supported class.
 */
final class CommonPsr17ClassesStrategy implements DiscoveryStrategy
{
    /**
     * @var array
     */
    private static $classes = [RequestFactoryInterface::class => ['Odigos\Phalcon\Http\Message\RequestFactory', 'Odigos\Nyholm\Psr7\Factory\Psr17Factory', 'Odigos\GuzzleHttp\Psr7\HttpFactory', 'Odigos\Http\Factory\Diactoros\RequestFactory', 'Odigos\Http\Factory\Guzzle\RequestFactory', 'Odigos\Http\Factory\Slim\RequestFactory', 'Odigos\Laminas\Diactoros\RequestFactory', 'Odigos\Slim\Psr7\Factory\RequestFactory', 'Odigos\HttpSoft\Message\RequestFactory'], ResponseFactoryInterface::class => ['Odigos\Phalcon\Http\Message\ResponseFactory', 'Odigos\Nyholm\Psr7\Factory\Psr17Factory', 'Odigos\GuzzleHttp\Psr7\HttpFactory', 'Odigos\Http\Factory\Diactoros\ResponseFactory', 'Odigos\Http\Factory\Guzzle\ResponseFactory', 'Odigos\Http\Factory\Slim\ResponseFactory', 'Odigos\Laminas\Diactoros\ResponseFactory', 'Odigos\Slim\Psr7\Factory\ResponseFactory', 'Odigos\HttpSoft\Message\ResponseFactory'], ServerRequestFactoryInterface::class => ['Odigos\Phalcon\Http\Message\ServerRequestFactory', 'Odigos\Nyholm\Psr7\Factory\Psr17Factory', 'Odigos\GuzzleHttp\Psr7\HttpFactory', 'Odigos\Http\Factory\Diactoros\ServerRequestFactory', 'Odigos\Http\Factory\Guzzle\ServerRequestFactory', 'Odigos\Http\Factory\Slim\ServerRequestFactory', 'Odigos\Laminas\Diactoros\ServerRequestFactory', 'Odigos\Slim\Psr7\Factory\ServerRequestFactory', 'Odigos\HttpSoft\Message\ServerRequestFactory'], StreamFactoryInterface::class => ['Odigos\Phalcon\Http\Message\StreamFactory', 'Odigos\Nyholm\Psr7\Factory\Psr17Factory', 'Odigos\GuzzleHttp\Psr7\HttpFactory', 'Odigos\Http\Factory\Diactoros\StreamFactory', 'Odigos\Http\Factory\Guzzle\StreamFactory', 'Odigos\Http\Factory\Slim\StreamFactory', 'Odigos\Laminas\Diactoros\StreamFactory', 'Odigos\Slim\Psr7\Factory\StreamFactory', 'Odigos\HttpSoft\Message\StreamFactory'], UploadedFileFactoryInterface::class => ['Odigos\Phalcon\Http\Message\UploadedFileFactory', 'Odigos\Nyholm\Psr7\Factory\Psr17Factory', 'Odigos\GuzzleHttp\Psr7\HttpFactory', 'Odigos\Http\Factory\Diactoros\UploadedFileFactory', 'Odigos\Http\Factory\Guzzle\UploadedFileFactory', 'Odigos\Http\Factory\Slim\UploadedFileFactory', 'Odigos\Laminas\Diactoros\UploadedFileFactory', 'Odigos\Slim\Psr7\Factory\UploadedFileFactory', 'Odigos\HttpSoft\Message\UploadedFileFactory'], UriFactoryInterface::class => ['Odigos\Phalcon\Http\Message\UriFactory', 'Odigos\Nyholm\Psr7\Factory\Psr17Factory', 'Odigos\GuzzleHttp\Psr7\HttpFactory', 'Odigos\Http\Factory\Diactoros\UriFactory', 'Odigos\Http\Factory\Guzzle\UriFactory', 'Odigos\Http\Factory\Slim\UriFactory', 'Odigos\Laminas\Diactoros\UriFactory', 'Odigos\Slim\Psr7\Factory\UriFactory', 'Odigos\HttpSoft\Message\UriFactory']];
    public static function getCandidates($type)
    {
        $candidates = [];
        if (isset(self::$classes[$type])) {
            foreach (self::$classes[$type] as $class) {
                $candidates[] = ['class' => $class, 'condition' => [$class]];
            }
        }
        return $candidates;
    }
}
