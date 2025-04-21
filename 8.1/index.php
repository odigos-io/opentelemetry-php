<?php

declare(strict_types=1);

require '/var/odigos/php/8.1/vendor/autoload.php';
// The above path is for Odigos auto-instrumentation (Odiglet)
// If you need to use this in your own code, you can use the following line instead:
// require 'vendor/autoload.php';

use OpenTelemetry\Contrib\Otlp\OtlpHttpTransportFactory;
use OpenTelemetry\Contrib\Otlp\SpanExporter;
use OpenTelemetry\Contrib\Otlp\MetricExporter;
use OpenTelemetry\SDK\Sdk;
use OpenTelemetry\SDK\Trace\NoopTracerProvider;
use OpenTelemetry\SDK\Trace\TracerProvider;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\Sampler\AlwaysOnSampler;
use OpenTelemetry\SDK\Trace\Sampler\ParentBased;
use OpenTelemetry\SDK\Metrics\NoopMeterProvider;
use OpenTelemetry\SDK\Metrics\MeterProvider;
use OpenTelemetry\SDK\Metrics\MetricReader\ExportingReader;
use OpenTelemetry\API\Trace\Propagation\TraceContextPropagator;

function getTraceProvider(): TracerProvider | NoopTracerProvider
{
  if (getenv('OTEL_TRACES_EXPORTER') == 'none') {
    return new NoopTracerProvider();
  }

  $tTransporter = (new OtlpHttpTransportFactory())
    ->create(rtrim(getenv('OTEL_EXPORTER_OTLP_ENDPOINT'), '/') . '/v1/traces', 'application/x-protobuf');

  $tExporter = new SpanExporter($tTransporter);
  // TODO: replace simple with batch
  $tProcesser = new SimpleSpanProcessor($tExporter);
  // $tProcesser = new BatchSpanProcessor($tExporter, Clock::getDefault());
  // $tProcesser = (new BatchSpanProcessorBuilder($tExporter))->build();
  $sSampler = new ParentBased(new AlwaysOnSampler());

  $tProvider = TracerProvider::builder()
    ->addSpanProcessor($tProcesser)
    ->setSampler($sSampler)
    ->build();

  return $tProvider;
}

function getMetricProvider(): MeterProvider | NoopMeterProvider
{
  if (getenv('OTEL_METRICS_EXPORTER') == 'none') {
    return new NoopMeterProvider();
  }

  $mTransporter = (new OtlpHttpTransportFactory())
    ->create(rtrim(getenv('OTEL_EXPORTER_OTLP_ENDPOINT'), '/') . '/v1/metrics', 'application/x-protobuf');

  $mExporter = new MetricExporter($mTransporter);
  $mReader = new ExportingReader($mExporter);

  return MeterProvider::builder()
    ->addReader($mReader)
    ->build();
}

Sdk::builder()
  ->setTracerProvider(getTraceProvider())
  ->setMeterProvider(getMetricProvider())
  ->setPropagator(TraceContextPropagator::getInstance())
  ->setAutoShutdown(false)
  ->buildAndRegisterGlobal();
