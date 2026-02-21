<?php

namespace Illuminate\Cache\RateLimiting;

class Unlimited extends \Illuminate\Cache\RateLimiting\GlobalLimit
{
    /**
     * Create a new limit instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(\PHP_INT_MAX);
    }
}
