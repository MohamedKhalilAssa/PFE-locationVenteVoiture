<?php

namespace App\Http\Controllers;

use Pusher\Pusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PusherAuthController extends Controller
{
    public function auth(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $pusherSocketId = $request->input('socket_id');
        $pusherChannelName = $request->input('channel_name');

        // Check if the user is authorized to access the Pusher channel
        // This can be custom logic based on your application's requirements

        // Generate authentication signature
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );

        $auth = $pusher->socket_auth($pusherChannelName, $pusherSocketId);

        // Return the authentication data to Pusher
        return response()->json($auth);
    }
}
