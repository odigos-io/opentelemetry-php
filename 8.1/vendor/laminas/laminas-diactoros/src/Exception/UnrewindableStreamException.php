<?php

declare (strict_types=1);
namespace Odigos\Laminas\Diactoros\Exception;

use RuntimeException;
class UnrewindableStreamException extends RuntimeException implements ExceptionInterface
{
    public static function forCallbackStream(): self
    {
        return new self('Callback streams cannot rewind position');
    }
}
