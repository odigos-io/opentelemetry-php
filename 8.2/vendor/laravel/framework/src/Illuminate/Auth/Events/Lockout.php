<?php

namespace Odigos\Illuminate\Auth\Events;

use Odigos\Illuminate\Http\Request;
class Lockout
{
    /**
     * The throttled request.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;
    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
