<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Common\Future;

use Closure;
use Throwable;
/**
 * @psalm-suppress MissingTemplateParam
 */
final class ErrorFuture implements \OpenTelemetry\SDK\Common\Future\FutureInterface
{
    public function __construct(private readonly Throwable $throwable)
    {
    }
    #[\Override]
    public function await(): never
    {
        throw $this->throwable;
    }
    #[\Override]
    public function map(Closure $closure): \OpenTelemetry\SDK\Common\Future\FutureInterface
    {
        return $this;
    }
    #[\Override]
    public function catch(Closure $closure): \OpenTelemetry\SDK\Common\Future\FutureInterface
    {
        $c = $closure;
        unset($closure);
        try {
            return new \OpenTelemetry\SDK\Common\Future\CompletedFuture($c($this->throwable));
        } catch (Throwable $e) {
            return new \OpenTelemetry\SDK\Common\Future\ErrorFuture($e);
        }
    }
}
