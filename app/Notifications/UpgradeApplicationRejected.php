<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpgradeApplicationRejected extends Notification
{
    use Queueable;

    protected $application;

    /**
     * Create a new notification instance.
     */
    public function __construct($application)
    {
        $this->application = $application;
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
        $itemName = '';
        $itemType = '';
        if (isset($this->application->legacy)) {
            $itemName = $this->application->legacy->title;
            $itemType = 'Legacy';
        } elseif (isset($this->application->recommendation)) {
            $itemName = $this->application->recommendation->place_name;
            $itemType = 'Rekomendasi';
        }

        return [
            'message' => "Mohon maaf, pengajuan upgrade Anda untuk {$itemType} '{$itemName}' telah ditolak.",
            'application_id' => $this->application->id,
            'application_type' => get_class($this->application),
        ];
    }
}