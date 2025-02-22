<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WeatherNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $alertData)
    {
        $this->data = $alertData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['mail'];

        //TODO more channels can be added
        if (!empty($notifiable->slack_webhook_url)) {
            $channels[] = 'slack';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Weather Alert')
            ->line('Severe weather conditions detected in your city.');

        foreach ($this->data as $key => $value) {
            $mail->line(ucwords(str_replace('_', ' ', $key)) . ': ' . $value);
        }

        return $mail->line('Stay safe!');
    }

    public function toSlack(object $notifiable)
    {
        //TODO create a SlackMessage
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
