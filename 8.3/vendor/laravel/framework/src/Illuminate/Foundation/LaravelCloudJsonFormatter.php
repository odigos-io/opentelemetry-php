<?php

namespace Illuminate\Foundation;

use Illuminate\Container\Container;
use Odigos\Monolog\Formatter\JsonFormatter;
use Odigos\Monolog\LogRecord;
class LaravelCloudJsonFormatter extends JsonFormatter
{
    /**
     * {@inheritdoc}
     */
    protected function normalizeRecord(LogRecord $record): array
    {
        $normalized = parent::normalizeRecord($record);
        $app = Container::getInstance();
        if ($app->bound('request')) {
            $requestId = $app->make('request')->header('Cloud-Request-ID');
            if ($requestId !== null) {
                $normalized['cloud_request_id'] = $requestId;
            }
        }
        return $normalized;
    }
}
