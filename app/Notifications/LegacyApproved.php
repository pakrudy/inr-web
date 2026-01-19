<?php

namespace App\Notifications;

use App\Models\Legacy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LegacyApproved extends Notification
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
                    ->subject('Legacy Anda Telah Disetujui dan Aktif')
                    ->line('Kabar baik! Pembayaran untuk legacy Anda yang berjudul "' . $this->legacy->title . '" telah dikonfirmasi.')
                    ->line('Legacy Anda sekarang aktif dan dapat dilihat oleh publik.')
                    ->action('Lihat Legacy Anda', route('customer.legacies.show', $this->legacy))
                    ->line('Terima kasih telah menjadi bagian dari komunitas kami!');
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
            'message' => 'Legacy Anda "' . $this->legacy->title . '" telah aktif.',
            'link' => route('customer.legacies.show', $this->legacy),
        ];
    }
}
