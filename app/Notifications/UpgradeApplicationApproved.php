<?php

namespace App\Notifications;

use App\Models\LegacyUpgradeApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpgradeApplicationApproved extends Notification
{
    use Queueable;

    /**
     * @var LegacyUpgradeApplication
     */
    public $application;

    /**
     * Create a new notification instance.
     */
    public function __construct(LegacyUpgradeApplication $application)
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
        return ['database']; // We'll store it in the database
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Pengajuan upgrade Anda untuk "' . $this->application->legacy->title . '" telah disetujui.',
            'action_text' => 'Lakukan Pembayaran',
            'action_url' => route('customer.legacies.payment.create', ['legacy' => $this->application->legacy, 'type' => 'upgrade']),
            'application_id' => $this->application->id,
        ];
    }
}