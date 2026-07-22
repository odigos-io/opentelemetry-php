<?php

namespace Odigos\Illuminate\Foundation\Queue;

use Odigos\Illuminate\Bus\Queueable as QueueableByBus;
use Odigos\Illuminate\Foundation\Bus\Dispatchable;
use Odigos\Illuminate\Queue\InteractsWithQueue;
use Odigos\Illuminate\Queue\SerializesModels;
trait Queueable
{
    use Dispatchable, InteractsWithQueue, QueueableByBus, SerializesModels;
}
