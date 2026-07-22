<?php

namespace Odigos\Illuminate\Bus\Events;

use Odigos\Illuminate\Bus\Batch;
class BatchFinished
{
    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Bus\Batch  $batch  The batch instance.
     */
    public function __construct(public Batch $batch)
    {
    }
}
