<?php

namespace Odigos\Illuminate\Foundation\Console;

use Odigos\Illuminate\Bus\Queueable;
use Odigos\Illuminate\Contracts\Console\Kernel as KernelContract;
use Odigos\Illuminate\Contracts\Queue\ShouldQueue;
use Odigos\Illuminate\Foundation\Bus\Dispatchable;
class QueuedCommand implements ShouldQueue
{
    use Dispatchable, Queueable;
    /**
     * The data to pass to the Artisan command.
     *
     * @var array
     */
    protected $data;
    /**
     * Create a new job instance.
     *
     * @param  array  $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * Handle the job.
     *
     * @param  \Illuminate\Contracts\Console\Kernel  $kernel
     * @return void
     */
    public function handle(KernelContract $kernel)
    {
        $kernel->call(...array_values($this->data));
    }
    /**
     * Get the display name for the queued job.
     *
     * @return string
     */
    public function displayName()
    {
        return array_values($this->data)[0];
    }
}
