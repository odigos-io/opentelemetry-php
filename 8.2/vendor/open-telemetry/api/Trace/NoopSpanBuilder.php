<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Trace;

use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\ContextInterface;
use OpenTelemetry\Context\ContextStorageInterface;
final class NoopSpanBuilder implements \OpenTelemetry\API\Trace\SpanBuilderInterface
{
    private ContextInterface|false|null $parentContext = null;
    public function __construct(private readonly ContextStorageInterface $contextStorage)
    {
    }
    #[\Override]
    public function setParent(ContextInterface|false|null $context): \OpenTelemetry\API\Trace\SpanBuilderInterface
    {
        $this->parentContext = $context;
        return $this;
    }
    #[\Override]
    public function addLink(\OpenTelemetry\API\Trace\SpanContextInterface $context, iterable $attributes = []): \OpenTelemetry\API\Trace\SpanBuilderInterface
    {
        return $this;
    }
    #[\Override]
    public function setAttribute(string $key, mixed $value): \OpenTelemetry\API\Trace\SpanBuilderInterface
    {
        return $this;
    }
    #[\Override]
    public function setAttributes(iterable $attributes): \OpenTelemetry\API\Trace\SpanBuilderInterface
    {
        return $this;
    }
    #[\Override]
    public function setStartTimestamp(int $timestampNanos): \OpenTelemetry\API\Trace\SpanBuilderInterface
    {
        return $this;
    }
    #[\Override]
    public function setSpanKind(int $spanKind): \OpenTelemetry\API\Trace\SpanBuilderInterface
    {
        return $this;
    }
    #[\Override]
    public function startSpan(): \OpenTelemetry\API\Trace\SpanInterface
    {
        $parentContext = Context::resolve($this->parentContext, $this->contextStorage);
        $span = \OpenTelemetry\API\Trace\Span::fromContext($parentContext);
        if ($span->isRecording()) {
            $span = \OpenTelemetry\API\Trace\Span::wrap($span->getContext());
        }
        return $span;
    }
}
