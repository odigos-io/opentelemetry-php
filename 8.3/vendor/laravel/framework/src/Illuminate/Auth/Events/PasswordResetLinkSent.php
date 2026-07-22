<?php

namespace Odigos\Illuminate\Auth\Events;

use Odigos\Illuminate\Queue\SerializesModels;
class PasswordResetLinkSent
{
    use SerializesModels;
    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user  The user instance.
     */
    public function __construct(public $user)
    {
    }
}
