<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: opentelemetry/proto/collector/trace/v1/trace_service.proto

namespace GPBMetadata\Opentelemetry\Proto\Collector\Trace\V1;

class TraceService
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Opentelemetry\Proto\Trace\V1\Trace::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
:opentelemetry/proto/collector/trace/v1/trace_service.proto&opentelemetry.proto.collector.trace.v1"`
ExportTraceServiceRequestC
resource_spans (2+.opentelemetry.proto.trace.v1.ResourceSpans"x
ExportTraceServiceResponseZ
partial_success (2A.opentelemetry.proto.collector.trace.v1.ExportTracePartialSuccess"J
ExportTracePartialSuccess
rejected_spans (
error_message (	2�
TraceService�
ExportA.opentelemetry.proto.collector.trace.v1.ExportTraceServiceRequestB.opentelemetry.proto.collector.trace.v1.ExportTraceServiceResponse" B�
)io.opentelemetry.proto.collector.trace.v1BTraceServiceProtoPZ1go.opentelemetry.io/proto/otlp/collector/trace/v1�&OpenTelemetry.Proto.Collector.Trace.V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

