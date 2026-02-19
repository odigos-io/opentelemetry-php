<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Trace\SpanSuppression\SemanticConventionSuppressionStrategy;

use OpenTelemetry\Context\ContextKeyInterface;
/**
 * @implements ContextKeyInterface<array<string, true>>
 *
 * @internal
 */
enum SemanticConventionSuppressionContextKey implements \OpenTelemetry\Context\ContextKeyInterface
{
    case Internal;
    case Client;
    case Server;
    case Producer;
    case Consumer;
}
