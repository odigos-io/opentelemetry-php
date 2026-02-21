<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Trace;

use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\ContextInterface;
use OpenTelemetry\Context\ContextKeys;
use OpenTelemetry\Context\ScopeInterface;
abstract class Span implements \OpenTelemetry\API\Trace\SpanInterface
{
    private static ?self $invalidSpan = null;
    /** @inheritDoc */
    #[\Override]
    final public static function fromContext(ContextInterface $context): \OpenTelemetry\API\Trace\SpanInterface
    {
        return $context->get(ContextKeys::span()) ?? self::getInvalid();
    }
    /** @inheritDoc */
    #[\Override]
    final public static function getCurrent(): \OpenTelemetry\API\Trace\SpanInterface
    {
        return self::fromContext(Context::getCurrent());
    }
    /** @inheritDoc */
    #[\Override]
    final public static function getInvalid(): \OpenTelemetry\API\Trace\SpanInterface
    {
        if (null === self::$invalidSpan) {
            self::$invalidSpan = new \OpenTelemetry\API\Trace\NonRecordingSpan(\OpenTelemetry\API\Trace\SpanContext::getInvalid());
        }
        return self::$invalidSpan;
    }
    /** @inheritDoc */
    #[\Override]
    final public static function wrap(\OpenTelemetry\API\Trace\SpanContextInterface $spanContext): \OpenTelemetry\API\Trace\SpanInterface
    {
        if (!$spanContext->isValid()) {
            return self::getInvalid();
        }
        return new \OpenTelemetry\API\Trace\NonRecordingSpan($spanContext);
    }
    /** @inheritDoc */
    #[\Override]
    final public function activate(): ScopeInterface
    {
        return Context::getCurrent()->withContextValue($this)->activate();
    }
    /** @inheritDoc */
    #[\Override]
    public function storeInContext(ContextInterface $context): ContextInterface
    {
        if (\OpenTelemetry\API\Trace\LocalRootSpan::isLocalRoot($context)) {
            $context = \OpenTelemetry\API\Trace\LocalRootSpan::store($context, $this);
        }
        return $context->with(ContextKeys::span(), $this);
    }
}
