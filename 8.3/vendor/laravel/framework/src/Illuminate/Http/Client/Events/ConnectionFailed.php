<?php

namespace Odigos\Illuminate\Http\Client\Events;

use Odigos\Illuminate\Http\Client\ConnectionException;
use Odigos\Illuminate\Http\Client\Request;
class ConnectionFailed
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Client\Request
     */
    public $request;
    /**
     * The exception instance.
     *
     * @var \Illuminate\Http\Client\ConnectionException
     */
    public $exception;
    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Http\Client\Request  $request
     * @param  \Illuminate\Http\Client\ConnectionException  $exception
     */
    public function __construct(Request $request, ConnectionException $exception)
    {
        $this->request = $request;
        $this->exception = $exception;
    }
}
