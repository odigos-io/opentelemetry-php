<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Common\Configuration\Resolver;

use OpenTelemetry\SDK\Common\Configuration\Configuration;
/**
 * @internal
 * @psalm-suppress TypeDoesNotContainType
 */
class PhpIniResolver implements \OpenTelemetry\SDK\Common\Configuration\Resolver\ResolverInterface
{
    public function __construct(private readonly \OpenTelemetry\SDK\Common\Configuration\Resolver\PhpIniAccessor $accessor = new \OpenTelemetry\SDK\Common\Configuration\Resolver\PhpIniAccessor())
    {
    }
    #[\Override]
    public function retrieveValue(string $variableName): mixed
    {
        $value = $this->accessor->get($variableName) ?: '';
        if (is_array($value)) {
            return implode(',', $value);
        }
        return $value;
    }
    #[\Override]
    public function hasVariable(string $variableName): bool
    {
        $value = $this->accessor->get($variableName);
        if ($value === []) {
            return \false;
        }
        return $value !== \false && !Configuration::isEmpty($value);
    }
}
