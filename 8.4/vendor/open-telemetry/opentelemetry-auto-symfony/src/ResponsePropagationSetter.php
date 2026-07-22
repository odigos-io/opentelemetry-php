<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Symfony;

use function assert;
use OpenTelemetry\Context\Propagation\PropagationSetterInterface;
use Odigos\Symfony\Component\HttpFoundation\Response;
/**
 * @internal
 */
final class ResponsePropagationSetter implements PropagationSetterInterface
{
    public static function instance(): self
    {
        static $instance;
        return $instance ??= new self();
    }
    /** @psalm-suppress InvalidReturnType
     *  @psalm-suppress PossiblyUnusedMethod
     */
    public function keys($carrier): array
    {
        assert(is_a($carrier, 'Symfony\\Component\\HttpFoundation\\Response'));
        /** @psalm-suppress InvalidReturnStatement */
        return $carrier->headers->keys();
    }
    public function set(&$carrier, string $key, string $value): void
    {
        assert(is_a($carrier, 'Symfony\\Component\\HttpFoundation\\Response'));
        $carrier->headers->set($key, $value);
    }
}
