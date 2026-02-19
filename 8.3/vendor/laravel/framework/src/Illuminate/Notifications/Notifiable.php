<?php

namespace Illuminate\Notifications;

trait Notifiable
{
    use \Illuminate\Notifications\HasDatabaseNotifications, \Illuminate\Notifications\RoutesNotifications;
}
