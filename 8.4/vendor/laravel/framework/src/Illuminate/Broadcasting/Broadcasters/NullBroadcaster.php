<?php

namespace Illuminate\Broadcasting\Broadcasters;

class NullBroadcaster extends \Illuminate\Broadcasting\Broadcasters\Broadcaster
{
    /**
     * {@inheritdoc}
     */
    public function auth($request)
    {
        //
    }
    /**
     * {@inheritdoc}
     */
    public function validAuthenticationResponse($request, $result)
    {
        //
    }
    /**
     * {@inheritdoc}
     */
    public function broadcast(array $channels, $event, array $payload = [])
    {
        //
    }
}
