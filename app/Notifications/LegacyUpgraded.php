<?php

namespace App\Notifications;

use App\Models\Legacy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LegacyUpgraded extends Notification
{
    use Queueable;

    public Legacy $legacy;

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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Legacy Anda Telah Di-upgrade')
                    ->line('Kabar baik! Pembayaran upgrade untuk legacy Anda yang berjudul "' . $this->legacy->title . '" telah dikonfirmasi.')
                    ->line('Legacy Anda sekarang sudah terindeks dan akan tampil dengan lencana verifikasi.')
                    ->action('Lihat Legacy Anda', route('customer.legacies.show', $this->legacy))
                    ->line('Terima kasih atas dukungan Anda!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'legacy_id' => $this->legacy->id,
            'title' => $this->legacy->title,
            'message' => 'Legacy Anda "' . $this->legacy->title . '" telah di-upgrade menjadi terindeks.',
            'link' => route('customer.legacies.show', $this->legacy),
        ];
    }
}
