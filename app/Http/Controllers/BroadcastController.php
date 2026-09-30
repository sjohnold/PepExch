<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

class BroadcastController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Get the authenticated user via Sanctum token
            $user = $request->user();

        if (!$user) {
            Log::warning('Broadcast API auth - no user', [
                'headers' => $request->headers->all(),
            ]);
            return response()->json(['error' => 'Unauthenticated'], 403);
        }

        // Set the user resolver for broadcast channel authorization
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Use Laravel's built-in broadcast authentication
        // This will check the channel authorization callbacks in routes/channels.php
        $response = Broadcast::auth($request);

        Log::info('Broadcast API auth success', [
            'user_id' => $user->id,
            'channel' => $request->input('channel_name'),
            // 'status' => $response->getStatusCode(),
        ]);

        return response()->json([
            'auth' => $response['auth'],
        ]);
        } catch (\Exception $e) {
            Log::error('Broadcasting API auth exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'channel' => $request->input('channel_name'),
                'socket_id' => $request->input('socket_id'),
            ]);

            return response()->json([
                'error' => $e->getMessage() ?: 'Authentication failed'
            ], 500);
        }
    }
}
