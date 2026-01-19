<?php

namespace App\Notifications;

use App\Models\Recommendation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecommendationExpired extends Notification
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
        $renewalUrl = route('customer.recommendations.payment.create', $this->recommendation);

        return (new MailMessage)
                    ->subject('Rekomendasi Anda Telah Kedaluwarsa')
                    ->line('Rekomendasi Anda untuk "' . $this->recommendation->place_name . '" telah kedaluwarsa.')
                    ->line('Untuk terus menampilkannya di platform kami, silakan lakukan perpanjangan.')
                    ->action('Perpanjang Sekarang', $renewalUrl)
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
            'recommendation_id' => $this->recommendation->id,
            'place_name' => $this->recommendation->place_name,
            'message' => 'Rekomendasi Anda untuk "' . $this->recommendation->place_name . '" telah kedaluwarsa. Klik untuk perpanjang.',
            'link' => route('customer.recommendations.show', $this->recommendation),
        ];
    }
}
