<?php

declare (strict_types=1);
namespace OpenTelemetry\Context\Propagation;

use OpenTelemetry\Context\ContextInterface;
/**
 * @experimental
 */
final class NoopResponsePropagator implements \OpenTelemetry\Context\Propagation\ResponsePropagatorInterface
{
    private static ?self $instance = null;
    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    #[\Override]
    public function inject(&$carrier, ?\OpenTelemetry\Context\Propagation\PropagationSetterInterface $setter = null, ?ContextInterface $context = null): void
    {
    }
}
