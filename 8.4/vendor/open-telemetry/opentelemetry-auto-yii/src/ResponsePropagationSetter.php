<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Yii;

use function assert;
use OpenTelemetry\Context\Propagation\PropagationSetterInterface;
use Odigos\yii\web\Response;
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
    /** @psalm-suppress InvalidReturnType */
    public function keys($carrier): array
    {
        assert(is_a($carrier, 'yii\\web\\Response'));
        return array_keys($carrier->getHeaders()->toArray());
    }
    public function set(&$carrier, string $key, string $value): void
    {
        assert(is_a($carrier, 'yii\\web\\Response'));
        $carrier->getHeaders()->set($key, $value);
    }
}
