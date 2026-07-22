<?php

namespace Odigos\Illuminate\Console\Events;

use Odigos\Illuminate\Console\Application;
class ArtisanStarting
{
    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Console\Application  $artisan  The Artisan application instance.
     */
    public function __construct(public Application $artisan)
    {
    }
}
