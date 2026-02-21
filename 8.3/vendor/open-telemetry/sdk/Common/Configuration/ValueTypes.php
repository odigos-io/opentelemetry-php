<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Common\Configuration;

/**
 * Environment variables defined by the OpenTelemetry specification and language specific variables for the PHP SDK.
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/configuration/sdk-environment-variables.md
 */
interface ValueTypes
{
    /**
     * General SDK Configuration
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/configuration/sdk-environment-variables.md#general-sdk-configuration
     */
    public const OTEL_RESOURCE_ATTRIBUTES = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::MAP;
    public const OTEL_SERVICE_NAME = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::STRING;
    public const OTEL_LOG_LEVEL = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::ENUM;
    public const OTEL_PROPAGATORS = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::LIST;
    public const OTEL_TRACES_SAMPLER = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::STRING;
    public const OTEL_TRACES_SAMPLER_ARG = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::MIXED;
    /**
     * Batch Span Processor
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/configuration/sdk-environment-variables.md#batch-span-processor
     */
    public const OTEL_BSP_SCHEDULE_DELAY = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_BSP_EXPORT_TIMEOUT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_BSP_MAX_QUEUE_SIZE = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_BSP_MAX_EXPORT_BATCH_SIZE = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    /**
     * Batch LogRecord Processor
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/configuration/sdk-environment-variables.md#batch-logrecord-processor
     */
    public const OTEL_BLRP_SCHEDULE_DELAY = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_BLRP_EXPORT_TIMEOUT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_BLRP_MAX_QUEUE_SIZE = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_BLRP_MAX_EXPORT_BATCH_SIZE = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    /**
     * Attribute Limits
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/configuration/sdk-environment-variables.md#attribute-limits
     */
    public const OTEL_ATTRIBUTE_VALUE_LENGTH_LIMIT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_ATTRIBUTE_COUNT_LIMIT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    /**
     * Span Limits
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/configuration/sdk-environment-variables.md#span-limits
     */
    public const OTEL_SPAN_ATTRIBUTE_VALUE_LENGTH_LIMIT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_SPAN_ATTRIBUTE_COUNT_LIMIT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_SPAN_EVENT_COUNT_LIMIT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_SPAN_LINK_COUNT_LIMIT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_EVENT_ATTRIBUTE_COUNT_LIMIT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_LINK_ATTRIBUTE_COUNT_LIMIT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    /**
     * LogRecord Limits
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/configuration/sdk-environment-variables.md#logrecord-limits
     */
    public const OTEL_LOGRECORD_ATTRIBUTE_VALUE_LENGTH_LIMIT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_LOGRECORD_ATTRIBUTE_COUNT_LIMIT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    /**
     * OTLP Exporter
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/protocol/exporter.md#configuration-options
     */
    // Endpoint
    public const OTEL_EXPORTER_OTLP_ENDPOINT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::STRING;
    public const OTEL_EXPORTER_OTLP_TRACES_ENDPOINT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::STRING;
    public const OTEL_EXPORTER_OTLP_METRICS_ENDPOINT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::STRING;
    // Insecure
    public const OTEL_EXPORTER_OTLP_INSECURE = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::BOOL;
    public const OTEL_EXPORTER_OTLP_TRACES_INSECURE = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::BOOL;
    public const OTEL_EXPORTER_OTLP_METRICS_INSECURE = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::BOOL;
    // Certificate File
    public const OTEL_EXPORTER_OTLP_CERTIFICATE = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::STRING;
    public const OTEL_EXPORTER_OTLP_TRACES_CERTIFICATE = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::STRING;
    public const OTEL_EXPORTER_OTLP_METRICS_CERTIFICATE = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::STRING;
    // Headers
    public const OTEL_EXPORTER_OTLP_HEADERS = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::MAP;
    public const OTEL_EXPORTER_OTLP_TRACES_HEADERS = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::MAP;
    public const OTEL_EXPORTER_OTLP_METRICS_HEADERS = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::MAP;
    // Compression
    public const OTEL_EXPORTER_OTLP_COMPRESSION = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::ENUM;
    public const OTEL_EXPORTER_OTLP_TRACES_COMPRESSION = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::ENUM;
    public const OTEL_EXPORTER_OTLP_METRICS_COMPRESSION = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::ENUM;
    // Timeout
    public const OTEL_EXPORTER_OTLP_TIMEOUT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_EXPORTER_OTLP_TRACES_TIMEOUT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_EXPORTER_OTLP_METRICS_TIMEOUT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    // Protocol
    public const OTEL_EXPORTER_OTLP_PROTOCOL = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::ENUM;
    public const OTEL_EXPORTER_OTLP_TRACES_PROTOCOL = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::ENUM;
    public const OTEL_EXPORTER_OTLP_METRICS_PROTOCOL = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::ENUM;
    /**
     * Zipkin Exporter
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/configuration/sdk-environment-variables.md#zipkin-exporter
     */
    public const OTEL_EXPORTER_ZIPKIN_ENDPOINT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::STRING;
    public const OTEL_EXPORTER_ZIPKIN_TIMEOUT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_EXPORTER_ZIPKIN_PROTOCOL = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::STRING;
    /**
     * Prometheus Exporter
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/configuration/sdk-environment-variables.md#prometheus-exporter
     */
    public const OTEL_EXPORTER_PROMETHEUS_HOST = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::STRING;
    public const OTEL_EXPORTER_PROMETHEUS_PORT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    /**
     * Exporter Selection
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/configuration/sdk-environment-variables.md#exporter-selection
     */
    public const OTEL_TRACES_EXPORTER = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::LIST;
    public const OTEL_METRICS_EXPORTER = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::LIST;
    public const OTEL_LOGS_EXPORTER = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::LIST;
    /**
     * Metrics SDK Configuration
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/configuration/sdk-environment-variables.md#metrics-sdk-configuration
     */
    public const OTEL_METRICS_EXEMPLAR_FILTER = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::ENUM;
    public const OTEL_METRIC_EXPORT_INTERVAL = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_METRIC_EXPORT_TIMEOUT = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::INTEGER;
    public const OTEL_EXPORTER_OTLP_METRICS_TEMPORALITY_PREFERENCE = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::ENUM;
    public const OTEL_EXPORTER_OTLP_METRICS_DEFAULT_HISTOGRAM_AGGREGATION = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::ENUM;
    /**
     * Language Specific Environment Variables
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/configuration/sdk-environment-variables.md#language-specific-environment-variables
     */
    public const OTEL_PHP_TRACES_PROCESSOR = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::ENUM;
    public const OTEL_PHP_LOGS_PROCESSOR = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::LIST;
    public const OTEL_PHP_DETECTORS = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::LIST;
    public const OTEL_PHP_AUTOLOAD_ENABLED = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::BOOL;
    public const OTEL_PHP_LOG_DESTINATION = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::ENUM;
    public const OTEL_PHP_INTERNAL_METRICS_ENABLED = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::BOOL;
    public const OTEL_PHP_DISABLED_INSTRUMENTATIONS = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::LIST;
    public const OTEL_EXPERIMENTAL_RESPONSE_PROPAGATORS = \OpenTelemetry\SDK\Common\Configuration\VariableTypes::LIST;
}
