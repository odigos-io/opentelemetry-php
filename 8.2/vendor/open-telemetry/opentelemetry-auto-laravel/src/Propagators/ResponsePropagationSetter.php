<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Laravel\Propagators;

use function assert;
use OpenTelemetry\Context\Propagation\PropagationSetterInterface;
use Odigos\Symfony\Component\HttpFoundation\Response;
/**
 * @internal
 */
class ResponsePropagationSetter implements PropagationSetterInterface
{
    public static function instance(): self
    {
        static $instance;
        return $instance ??= new self();
    }
    public function set(&$carrier, string $key, string $value): void
    {
        assert(is_a($carrier, 'Symfony\\Component\\HttpFoundation\\Response'));
        $carrier->headers->set($key, $value);
    }
}
