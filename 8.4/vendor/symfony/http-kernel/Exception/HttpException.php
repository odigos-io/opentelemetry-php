<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\HttpKernel\Exception;

/**
 * HttpException.
 *
 * @author Kris Wallsmith <kris@symfony.com>
 */
class HttpException extends \RuntimeException implements \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface
{
    public function __construct(private int $statusCode, string $message = '', ?\Throwable $previous = null, private array $headers = [], int $code = 0)
    {
        parent::__construct($message, $code, $previous);
    }
    public static function fromStatusCode(int $statusCode, string $message = '', ?\Throwable $previous = null, array $headers = [], int $code = 0): self
    {
        return match ($statusCode) {
            400 => new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException($message, $previous, $code, $headers),
            403 => new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException($message, $previous, $code, $headers),
            404 => new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException($message, $previous, $code, $headers),
            406 => new \Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException($message, $previous, $code, $headers),
            409 => new \Symfony\Component\HttpKernel\Exception\ConflictHttpException($message, $previous, $code, $headers),
            410 => new \Symfony\Component\HttpKernel\Exception\GoneHttpException($message, $previous, $code, $headers),
            411 => new \Symfony\Component\HttpKernel\Exception\LengthRequiredHttpException($message, $previous, $code, $headers),
            412 => new \Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException($message, $previous, $code, $headers),
            423 => new \Symfony\Component\HttpKernel\Exception\LockedHttpException($message, $previous, $code, $headers),
            415 => new \Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException($message, $previous, $code, $headers),
            422 => new \Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException($message, $previous, $code, $headers),
            428 => new \Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException($message, $previous, $code, $headers),
            429 => new \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException(null, $message, $previous, $code, $headers),
            503 => new \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException(null, $message, $previous, $code, $headers),
            default => new static($statusCode, $message, $previous, $headers, $code),
        };
    }
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
    public function getHeaders(): array
    {
        return $this->headers;
    }
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }
}
