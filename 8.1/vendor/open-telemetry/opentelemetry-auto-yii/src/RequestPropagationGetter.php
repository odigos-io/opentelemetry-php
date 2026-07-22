<?php

declare (strict_types=1);
namespace Odigos\OpenTelemetry\Contrib\Instrumentation\Yii;

use function assert;
use OpenTelemetry\Context\Propagation\PropagationGetterInterface;
use Odigos\yii\web\Request;
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
    /** @psalm-suppress InvalidReturnType */
    public function keys($carrier): array
    {
        assert(is_a($carrier, 'yii\\web\\Request'));
        return array_keys($carrier->getHeaders()->toArray());
    }
    public function get($carrier, string $key): ?string
    {
        assert(is_a($carrier, 'yii\\web\\Request'));
        $result = $carrier->getHeaders()->get($key, null, \true);
        if (is_array($result)) {
            return (string) array_values($result)[0];
        }
        return $result;
    }
}
