<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PushSubscriptionController extends Controller
{
    // POST /push/subscribe
    public function store(Request $request)
    {
        $request->validate([
            'endpoint'       => 'required|string',
            'keys.p256dh'    => 'nullable|string',
            'keys.auth'      => 'nullable|string',
        ]);

        $request->user()->updatePushSubscription(
            $request->endpoint,
            $request->input('keys.p256dh'),
            $request->input('keys.auth'),
            $request->input('contentEncoding', 'aesgcm')
        );

        return response()->json(['status' => 'subscribed']);
    }

    // DELETE /push/unsubscribe
    public function destroy(Request $request)
    {
        $request->validate(['endpoint' => 'required|string']);

        $request->user()->deletePushSubscription($request->endpoint);

        return response()->json(['status' => 'unsubscribed']);
    }
}
