<?php

namespace App\Notifications;

use App\Models\MatchModel;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MatchFoundNotification extends Notification
{
    public function __construct(
        protected MatchModel $match
    ) {}
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🎯 Найдена сделка на Uibirzhasi.kz')
            ->greeting('Здравствуйте!')
            ->line('Для вашего объявления найдена подходящая пара.')
            ->action('Открыть сделку', route('matches.index'))
            ->line('Пожалуйста, внесите депозит в течение 24 часов.');
    }
    public function toArray($notifiable): array
    {
        return [
            'type'  => 'match_found',
            'match' => $this->match->id,
            'price' => $this->match->price,
        ];
    }
}
