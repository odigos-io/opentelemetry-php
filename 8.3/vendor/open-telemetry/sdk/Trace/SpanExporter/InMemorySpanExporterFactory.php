<?php

declare (strict_types=1);
namespace OpenTelemetry\SDK\Trace\SpanExporter;

use OpenTelemetry\SDK\Common\Export\InMemoryStorageManager;
use OpenTelemetry\SDK\Trace\SpanExporterInterface;
class InMemorySpanExporterFactory implements \OpenTelemetry\SDK\Trace\SpanExporter\SpanExporterFactoryInterface
{
    #[\Override]
    public function create(): SpanExporterInterface
    {
        return new \OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter(InMemoryStorageManager::spans());
    }
}
