<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Common\Future;

use Closure;
use Throwable;
/**
 * @template T
 * @template-implements FutureInterface<T>
 */
final class CompletedFuture implements \OpenTelemetry\SDK\Common\Future\FutureInterface
{
    /**
     * @param T $value
     */
    public function __construct(private $value)
    {
    }
    #[\Override]
    public function await()
    {
        return $this->value;
    }
    #[\Override]
    public function map(Closure $closure): \OpenTelemetry\SDK\Common\Future\FutureInterface
    {
        $c = $closure;
        unset($closure);
        try {
            return new \OpenTelemetry\SDK\Common\Future\CompletedFuture($c($this->value));
        } catch (Throwable $e) {
            return new \OpenTelemetry\SDK\Common\Future\ErrorFuture($e);
        }
    }
    #[\Override]
    public function catch(Closure $closure): \OpenTelemetry\SDK\Common\Future\FutureInterface
    {
        return $this;
    }
}
