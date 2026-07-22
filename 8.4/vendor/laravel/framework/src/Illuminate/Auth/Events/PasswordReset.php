<?php

namespace Odigos\Illuminate\Auth\Events;

use Odigos\Illuminate\Queue\SerializesModels;
class PasswordReset
{
    use SerializesModels;
    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user  The user.
     */
    public function __construct(public $user)
    {
    }
}
