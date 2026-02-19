<?php

declare (strict_types=1);
namespace OpenTelemetry\Contrib\Otlp;

use OpenTelemetry\SDK\Common\Export\Stream\StreamTransportFactory;
use OpenTelemetry\SDK\Trace\SpanExporter\SpanExporterFactoryInterface;
use OpenTelemetry\SDK\Trace\SpanExporterInterface;
class StdoutSpanExporterFactory implements SpanExporterFactoryInterface
{
    #[\Override]
    public function create(): SpanExporterInterface
    {
        $transport = (new StreamTransportFactory())->create('php://stdout', \OpenTelemetry\Contrib\Otlp\ContentTypes::NDJSON);
        return new \OpenTelemetry\Contrib\Otlp\SpanExporter($transport);
    }
}
