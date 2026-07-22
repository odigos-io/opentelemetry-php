<?php

namespace Odigos\Illuminate\Log\Context;

use Odigos\Illuminate\Container\Container;
use Odigos\Illuminate\Contracts\Log\ContextLogProcessor as ContextLogProcessorContract;
use Odigos\Illuminate\Log\Context\Repository as ContextRepository;
use Odigos\Monolog\LogRecord;
class ContextLogProcessor implements ContextLogProcessorContract
{
    /**
     * Add contextual data to the log's "extra" parameter.
     *
     * @param  \Monolog\LogRecord  $record
     * @return \Monolog\LogRecord
     */
    public function __invoke(LogRecord $record): LogRecord
    {
        $app = Container::getInstance();
        if (!$app->bound(ContextRepository::class)) {
            return $record;
        }
        return $record->with(extra: [...$record->extra, ...$app->get(ContextRepository::class)->all()]);
    }
}
