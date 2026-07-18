<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = CustomerNotification::where('customer_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(20);

        $unreadCount = CustomerNotification::where('customer_id', $request->user()->id)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'notifications' => $notifications->items(),
            'unread_count' => $unreadCount,
            'meta' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'total' => $notifications->total(),
            ],
        ]);
    }

    public function markRead(Request $request, $id)
    {
        $notification = CustomerNotification::where('customer_id', $request->user()->id)
            ->findOrFail($id);

        $notification->update(['read_at' => now()]);

        return response()->json(['message' => 'Notification marked as read.']);
    }

    public function markAllRead(Request $request)
    {
        CustomerNotification::where('customer_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'All notifications marked as read.']);
    }
}
