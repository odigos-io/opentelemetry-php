<?php

namespace Odigos\Illuminate\Mail\Events;

use Odigos\Symfony\Component\Mime\Email;
class MessageSending
{
    /**
     * Create a new event instance.
     *
     * @param  \Symfony\Component\Mime\Email  $message  The Symfony Email instance.
     * @param  array  $data  The message data.
     */
    public function __construct(public Email $message, public array $data = [])
    {
    }
}
