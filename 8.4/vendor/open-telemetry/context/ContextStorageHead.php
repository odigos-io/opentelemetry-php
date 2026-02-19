<?php

declare (strict_types=1);
namespace OpenTelemetry\Context;

/**
 * @internal
 */
final class ContextStorageHead
{
    public ?\OpenTelemetry\Context\ContextStorageNode $node = null;
    public function __construct(public \OpenTelemetry\Context\ContextStorageHeadAware $storage)
    {
    }
}
