<?php

namespace Odigos\Illuminate\Auth\Listeners;

use Odigos\Illuminate\Auth\Events\Registered;
use Odigos\Illuminate\Contracts\Auth\MustVerifyEmail;
class SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if ($event->user instanceof MustVerifyEmail && !$event->user->hasVerifiedEmail()) {
            $event->user->sendEmailVerificationNotification();
        }
    }
}
