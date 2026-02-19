<?php

declare (strict_types=1);
namespace OpenTelemetry\Context;

use ArrayAccess;
/**
 * @psalm-suppress MissingTemplateParam
 */
interface ContextStorageScopeInterface extends \OpenTelemetry\Context\ScopeInterface, ArrayAccess
{
    /**
     * Returns the context associated with this scope.
     *
     * @return ContextInterface associated context
     */
    public function context(): \OpenTelemetry\Context\ContextInterface;
    /**
     * @param string $offset
     */
    #[\Override]
    public function offsetSet($offset, $value): void;
}
