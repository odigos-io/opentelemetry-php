<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Propagators;

use function assert;
use Odigos\Illuminate\Http\Request;
use OpenTelemetry\Context\Propagation\PropagationGetterInterface;
/**
 * @internal
 */
class HeadersPropagator implements PropagationGetterInterface
{
    public static function instance(): self
    {
        static $instance;
        return $instance ??= new self();
    }
    /** @psalm-suppress MoreSpecificReturnType */
    public function keys($carrier): array
    {
        assert(is_a($carrier, 'Illuminate\\Http\\Request'));
        /** @psalm-suppress LessSpecificReturnStatement */
        return $carrier->headers->keys();
    }
    public function get($carrier, string $key): ?string
    {
        assert(is_a($carrier, 'Illuminate\\Http\\Request'));
        return $carrier->headers->get($key);
    }
}
