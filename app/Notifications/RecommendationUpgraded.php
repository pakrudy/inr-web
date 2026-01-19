<?php

namespace App\Notifications;

use App\Models\Recommendation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecommendationUpgraded extends Notification
{
    use Queueable;

    public Recommendation $recommendation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Recommendation $recommendation)
    {
        $this->recommendation = $recommendation;
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
                    ->subject('Rekomendasi Anda Telah Di-upgrade')
                    ->line('Kabar baik! Pembayaran upgrade untuk rekomendasi Anda untuk "' . $this->recommendation->place_name . '" telah dikonfirmasi.')
                    ->line('Rekomendasi Anda sekarang terindeks dan akan tampil dengan lencana "Recommended".')
                    ->action('Lihat Rekomendasi Anda', route('customer.recommendations.show', $this->recommendation))
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
            'recommendation_id' => $this->recommendation->id,
            'place_name' => $this->recommendation->place_name,
            'message' => 'Rekomendasi Anda untuk "' . $this->recommendation->place_name . '" telah di-upgrade menjadi terindeks.',
            'link' => route('customer.recommendations.show', $this->recommendation),
        ];
    }
}
