<?php

namespace App\Notifications;

use App\Models\Legacy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IndexedStatusExpired extends Notification
{
    use Queueable;

    protected $legacy;

    /**
     * Create a new notification instance.
     */
    public function __construct(Legacy $legacy)
    {
        $this->legacy = $legacy;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "Masa aktif status Terindeks untuk Legacy '{$this->legacy->title}' telah berakhir.",
            'legacy_id' => $this->legacy->id,
        ];
    }
}