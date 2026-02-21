<?php

declare (strict_types=1);
namespace Odigos;

\OpenTelemetry\SDK\Registry::registerSpanExporterFactory('otlp', \Odigos\OpenTelemetry\Contrib\Otlp\SpanExporterFactory::class);
\OpenTelemetry\SDK\Registry::registerSpanExporterFactory('otlp/stdout', \Odigos\OpenTelemetry\Contrib\Otlp\StdoutSpanExporterFactory::class);
\OpenTelemetry\SDK\Registry::registerMetricExporterFactory('otlp', \Odigos\OpenTelemetry\Contrib\Otlp\MetricExporterFactory::class);
\OpenTelemetry\SDK\Registry::registerMetricExporterFactory('otlp/stdout', \Odigos\OpenTelemetry\Contrib\Otlp\StdoutMetricExporterFactory::class);
\OpenTelemetry\SDK\Registry::registerTransportFactory('http', \Odigos\OpenTelemetry\Contrib\Otlp\OtlpHttpTransportFactory::class);
\OpenTelemetry\SDK\Registry::registerLogRecordExporterFactory('otlp', \Odigos\OpenTelemetry\Contrib\Otlp\LogsExporterFactory::class);
\OpenTelemetry\SDK\Registry::registerLogRecordExporterFactory('otlp/stdout', \Odigos\OpenTelemetry\Contrib\Otlp\StdoutLogsExporterFactory::class);
