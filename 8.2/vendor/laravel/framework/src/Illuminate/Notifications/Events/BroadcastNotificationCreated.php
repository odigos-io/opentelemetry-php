<?php

namespace Odigos\Illuminate\Notifications\Events;

use Odigos\Illuminate\Broadcasting\PrivateChannel;
use Odigos\Illuminate\Bus\Queueable;
use Odigos\Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Odigos\Illuminate\Notifications\AnonymousNotifiable;
use Odigos\Illuminate\Queue\SerializesModels;
use Odigos\Illuminate\Support\Arr;
use Odigos\Illuminate\Support\Collection;
class BroadcastNotificationCreated implements ShouldBroadcast
{
    use Queueable, SerializesModels;
    /**
     * Create a new event instance.
     *
     * @param  mixed  $notifiable  The notifiable entity who received the notification.
     * @param  \Illuminate\Notifications\Notification  $notification  The notification instance.
     * @param  array  $data  The notification data.
     */
    public function __construct(public $notifiable, public $notification, public $data = [])
    {
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        if ($this->notifiable instanceof AnonymousNotifiable && $this->notifiable->routeNotificationFor('broadcast')) {
            $channels = Arr::wrap($this->notifiable->routeNotificationFor('broadcast'));
        } else {
            $channels = $this->notification->broadcastOn();
        }
        if (!empty($channels)) {
            return $channels;
        }
        if (is_string($channels = $this->channelName())) {
            return [new PrivateChannel($channels)];
        }
        return (new Collection($channels))->map(fn($channel) => new PrivateChannel($channel))->all();
    }
    /**
     * Get the broadcast channel name for the event.
     *
     * @return array|string
     */
    protected function channelName()
    {
        if (method_exists($this->notifiable, 'receivesBroadcastNotificationsOn')) {
            return $this->notifiable->receivesBroadcastNotificationsOn($this->notification);
        }
        $class = str_replace('\\', '.', get_class($this->notifiable));
        return $class . '.' . $this->notifiable->getKey();
    }
    /**
     * Get the data that should be sent with the broadcasted event.
     *
     * @return array
     */
    public function broadcastWith()
    {
        if (method_exists($this->notification, 'broadcastWith')) {
            return $this->notification->broadcastWith();
        }
        return array_merge($this->data, ['id' => $this->notification->id, 'type' => $this->broadcastType()]);
    }
    /**
     * Get the type of the notification being broadcast.
     *
     * @return string
     */
    public function broadcastType()
    {
        return method_exists($this->notification, 'broadcastType') ? $this->notification->broadcastType() : get_class($this->notification);
    }
    /**
     * Get the event name of the notification being broadcast.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return method_exists($this->notification, 'broadcastAs') ? $this->notification->broadcastAs() : __CLASS__;
    }
}
