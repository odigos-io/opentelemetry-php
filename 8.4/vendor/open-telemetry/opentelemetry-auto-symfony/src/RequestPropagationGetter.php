<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Symfony;

use function assert;
use OpenTelemetry\Context\Propagation\PropagationGetterInterface;
use Odigos\Symfony\Component\HttpFoundation\Request;
/**
 * @internal
 */
final class RequestPropagationGetter implements PropagationGetterInterface
{
    public static function instance(): self
    {
        static $instance;
        return $instance ??= new self();
    }
    /** @psalm-suppress MoreSpecificReturnType */
    public function keys($carrier): array
    {
        assert(is_a($carrier, 'Symfony\\Component\\HttpFoundation\\Request'));
        /** @psalm-suppress LessSpecificReturnStatement */
        return $carrier->headers->keys();
    }
    public function get($carrier, string $key): ?string
    {
        assert(is_a($carrier, 'Symfony\\Component\\HttpFoundation\\Request'));
        return $carrier->headers->get($key);
    }
}
