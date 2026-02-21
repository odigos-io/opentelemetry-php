<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Trace;

use function hex2bin;
final class SpanContext implements \OpenTelemetry\API\Trace\SpanContextInterface
{
    private static ?\OpenTelemetry\API\Trace\SpanContextInterface $invalidContext = null;
    /**
     * @see https://www.w3.org/TR/trace-context/#trace-flags
     * @see https://www.w3.org/TR/trace-context/#sampled-flag
     */
    private readonly bool $isSampled;
    private bool $isValid = \true;
    private function __construct(private string $traceId, private string $spanId, private readonly int $traceFlags, private readonly bool $isRemote, private readonly ?\OpenTelemetry\API\Trace\TraceStateInterface $traceState = null)
    {
        // TraceId must be exactly 16 bytes (32 chars) and at least one non-zero byte
        // SpanId must be exactly 8 bytes (16 chars) and at least one non-zero byte
        if (!\OpenTelemetry\API\Trace\SpanContextValidator::isValidTraceId($traceId) || !\OpenTelemetry\API\Trace\SpanContextValidator::isValidSpanId($spanId)) {
            $this->traceId = \OpenTelemetry\API\Trace\SpanContextValidator::INVALID_TRACE;
            $this->spanId = \OpenTelemetry\API\Trace\SpanContextValidator::INVALID_SPAN;
            $this->isValid = \false;
        }
        $this->isSampled = ($traceFlags & \OpenTelemetry\API\Trace\TraceFlags::SAMPLED) === \OpenTelemetry\API\Trace\TraceFlags::SAMPLED;
    }
    #[\Override]
    public function getTraceId(): string
    {
        return $this->traceId;
    }
    #[\Override]
    public function getTraceIdBinary(): string
    {
        return hex2bin($this->traceId);
    }
    #[\Override]
    public function getSpanId(): string
    {
        return $this->spanId;
    }
    #[\Override]
    public function getSpanIdBinary(): string
    {
        return hex2bin($this->spanId);
    }
    #[\Override]
    public function getTraceState(): ?\OpenTelemetry\API\Trace\TraceStateInterface
    {
        return $this->traceState;
    }
    #[\Override]
    public function isSampled(): bool
    {
        return $this->isSampled;
    }
    #[\Override]
    public function isValid(): bool
    {
        return $this->isValid;
    }
    #[\Override]
    public function isRemote(): bool
    {
        return $this->isRemote;
    }
    #[\Override]
    public function getTraceFlags(): int
    {
        return $this->traceFlags;
    }
    /** @inheritDoc */
    #[\Override]
    public static function createFromRemoteParent(string $traceId, string $spanId, int $traceFlags = \OpenTelemetry\API\Trace\TraceFlags::DEFAULT, ?\OpenTelemetry\API\Trace\TraceStateInterface $traceState = null): \OpenTelemetry\API\Trace\SpanContextInterface
    {
        return new self($traceId, $spanId, $traceFlags, \true, $traceState);
    }
    /** @inheritDoc */
    #[\Override]
    public static function create(string $traceId, string $spanId, int $traceFlags = \OpenTelemetry\API\Trace\TraceFlags::DEFAULT, ?\OpenTelemetry\API\Trace\TraceStateInterface $traceState = null): \OpenTelemetry\API\Trace\SpanContextInterface
    {
        return new self($traceId, $spanId, $traceFlags, \false, $traceState);
    }
    /** @inheritDoc */
    #[\Override]
    public static function getInvalid(): \OpenTelemetry\API\Trace\SpanContextInterface
    {
        if (null === self::$invalidContext) {
            self::$invalidContext = self::create(\OpenTelemetry\API\Trace\SpanContextValidator::INVALID_TRACE, \OpenTelemetry\API\Trace\SpanContextValidator::INVALID_SPAN, 0);
        }
        return self::$invalidContext;
    }
}
