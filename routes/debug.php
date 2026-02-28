<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug-notifications', function () {
    $user = auth()->user();

    return [
        'current_user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'organization_id' => $user->organization_id,
        ],
        'notifications' => [
            'total' => $user->notifications()->count(),
            'unread' => $user->unreadNotifications->count(),
            'recent' => $user->notifications()->latest()->take(3)->get()->map(function ($n) {
                return [
                    'type' => $n->type,
                    'data' => $n->data,
                    'read_at' => $n->read_at,
                    'created_at' => $n->created_at->format('Y-m-d H:i:s'),
                ];
            }),
        ],
        'all_notifications_in_db' => \Illuminate\Notifications\DatabaseNotification::latest()->take(5)->get()->map(function ($n) {
            return [
                'notifiable_id' => $n->notifiable_id,
                'notifiable_type' => $n->notifiable_type,
                'type' => $n->type,
                'created_at' => $n->created_at->format('Y-m-d H:i:s'),
            ];
        }),
    ];
})->middleware('auth');
