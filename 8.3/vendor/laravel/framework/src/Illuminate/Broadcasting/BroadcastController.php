<?php

namespace Odigos\Illuminate\Broadcasting;

use Odigos\Illuminate\Http\Request;
use Odigos\Illuminate\Routing\Controller;
use Odigos\Illuminate\Support\Facades\Broadcast;
use Odigos\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
class BroadcastController extends Controller
{
    /**
     * Authenticate the request for channel access.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        if ($request->hasSession()) {
            $request->session()->reflash();
        }
        return Broadcast::auth($request);
    }
    /**
     * Authenticate the current user.
     *
     * See: https://pusher.com/docs/channels/server_api/authenticating-users/#user-authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|null
     *
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function authenticateUser(Request $request)
    {
        if ($request->hasSession()) {
            $request->session()->reflash();
        }
        return Broadcast::resolveAuthenticatedUser($request) ?? throw new AccessDeniedHttpException();
    }
}
