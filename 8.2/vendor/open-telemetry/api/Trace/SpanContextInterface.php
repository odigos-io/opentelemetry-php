<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Trace;

/**
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#spancontext
 */
interface SpanContextInterface
{
    public static function createFromRemoteParent(string $traceId, string $spanId, int $traceFlags = \OpenTelemetry\API\Trace\TraceFlags::DEFAULT, ?\OpenTelemetry\API\Trace\TraceStateInterface $traceState = null): \OpenTelemetry\API\Trace\SpanContextInterface;
    public static function getInvalid(): \OpenTelemetry\API\Trace\SpanContextInterface;
    public static function create(string $traceId, string $spanId, int $traceFlags = \OpenTelemetry\API\Trace\TraceFlags::DEFAULT, ?\OpenTelemetry\API\Trace\TraceStateInterface $traceState = null): \OpenTelemetry\API\Trace\SpanContextInterface;
    /** @psalm-mutation-free */
    public function getTraceId(): string;
    public function getTraceIdBinary(): string;
    /** @psalm-mutation-free */
    public function getSpanId(): string;
    public function getSpanIdBinary(): string;
    public function getTraceFlags(): int;
    public function getTraceState(): ?\OpenTelemetry\API\Trace\TraceStateInterface;
    public function isValid(): bool;
    public function isRemote(): bool;
    public function isSampled(): bool;
}
