<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of user's notifications.
     */
    public function index()
    {
        $user = auth()->user();

        // Build query based on user role
        $query = $user->notifications()->latest();

        // Filter notifications by role
        if ($user->hasRole('finance')) {
            // Finance users only see invoice and payment notifications
            $query->whereIn('type', [
                'App\\Notifications\\InvoiceCreatedNotification',
                'App\\Notifications\\InvoicePaidNotification',
                'App\\Notifications\\InvoiceOverdueNotification',
                'App\\Notifications\\PaymentReceivedNotification',
            ]);
        } elseif ($user->hasRole('sales')) {
            // Sales users only see deal and lead notifications
            $query->whereIn('type', [
                'App\\Notifications\\LeadCreatedNotification',
                'App\\Notifications\\DealCreatedNotification',
                'App\\Notifications\\DealAssignedNotification',
                'App\\Notifications\\DealStageChangedNotification',
                'App\\Notifications\\DealWonNotification',
                'App\\Notifications\\DealLostNotification',
            ]);
        }
        // Admin users see all notifications (no filter)

        $notifications = $query->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Get unread notification count for the authenticated user.
     */
    public function getUnreadCount()
    {
        $user = auth()->user();
        $query = $user->unreadNotifications();

        // Filter by role
        if ($user->hasRole('finance')) {
            $query->whereIn('type', [
                'App\\Notifications\\InvoiceCreatedNotification',
                'App\\Notifications\\InvoicePaidNotification',
                'App\\Notifications\\InvoiceOverdueNotification',
                'App\\Notifications\\PaymentReceivedNotification',
            ]);
        } elseif ($user->hasRole('sales')) {
            $query->whereIn('type', [
                'App\\Notifications\\LeadCreatedNotification',
                'App\\Notifications\\DealCreatedNotification',
                'App\\Notifications\\DealAssignedNotification',
                'App\\Notifications\\DealStageChangedNotification',
                'App\\Notifications\\DealWonNotification',
                'App\\Notifications\\DealLostNotification',
            ]);
        }

        $count = $query->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Delete a specific notification.
     */
    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Get latest notifications for polling.
     */
    public function getLatest(Request $request)
    {
        $user = auth()->user();
        $lastCheckTime = $request->input('last_check_time');

        // Build query with role filtering
        $unreadQuery = $user->unreadNotifications();
        $allQuery = $user->notifications();

        // Apply role-based filters
        if ($user->hasRole('finance')) {
            $typeFilter = [
                'App\\Notifications\\InvoiceCreatedNotification',
                'App\\Notifications\\InvoicePaidNotification',
                'App\\Notifications\\InvoiceOverdueNotification',
                'App\\Notifications\\PaymentReceivedNotification',
            ];
            $unreadQuery->whereIn('type', $typeFilter);
            $allQuery->whereIn('type', $typeFilter);
        } elseif ($user->hasRole('sales')) {
            $typeFilter = [
                'App\\Notifications\\LeadCreatedNotification',
                'App\\Notifications\\DealCreatedNotification',
                'App\\Notifications\\DealAssignedNotification',
                'App\\Notifications\\DealStageChangedNotification',
                'App\\Notifications\\DealWonNotification',
                'App\\Notifications\\DealLostNotification',
            ];
            $unreadQuery->whereIn('type', $typeFilter);
            $allQuery->whereIn('type', $typeFilter);
        }

        // Get unread count
        $unreadCount = $unreadQuery->count();

        // Get recent unread notifications (last 5)
        $recentNotifications = $unreadQuery->latest()->take(5)->get();

        // Get latest notification
        $latestNotification = $allQuery->latest()->first();

        // Check if there are new notifications since last check
        $hasNew = false;
        if ($lastCheckTime && $latestNotification) {
            $hasNew = $latestNotification->created_at->isAfter($lastCheckTime);
        }

        return response()->json([
            'unread_count' => $unreadCount,
            'recent_notifications' => $recentNotifications,
            'latest_notification' => $latestNotification,
            'has_new' => $hasNew,
            'current_time' => now()->toISOString(),
        ]);
    }
}
