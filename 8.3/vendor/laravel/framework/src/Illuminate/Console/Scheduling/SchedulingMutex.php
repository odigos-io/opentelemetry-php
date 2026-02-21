<?php

namespace Illuminate\Console\Scheduling;

use DateTimeInterface;
interface SchedulingMutex
{
    /**
     * Attempt to obtain a scheduling mutex for the given event.
     *
     * @param  \Illuminate\Console\Scheduling\Event  $event
     * @param  \DateTimeInterface  $time
     * @return bool
     */
    public function create(\Illuminate\Console\Scheduling\Event $event, DateTimeInterface $time);
    /**
     * Determine if a scheduling mutex exists for the given event.
     *
     * @param  \Illuminate\Console\Scheduling\Event  $event
     * @param  \DateTimeInterface  $time
     * @return bool
     */
    public function exists(\Illuminate\Console\Scheduling\Event $event, DateTimeInterface $time);
}
