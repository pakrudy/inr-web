<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Mark a specific notification as read and redirect to its link.
     *
     * @param  \Illuminate\Notifications\DatabaseNotification  $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function read(DatabaseNotification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if (Auth::id() !== $notification->notifiable_id) {
            abort(403);
        }

        // Mark as read
        $notification->markAsRead();

        // Redirect to the link stored in the notification data
        $link = $notification->data['link'] ?? '/dashboard';

        return redirect($link);
    }
}