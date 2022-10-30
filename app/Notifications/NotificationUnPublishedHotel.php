<?php

namespace App\Notifications;

use App\User;
use Domain\Hotel\Models\Hotel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notify user when created general User-Hotel
 */
class NotificationUnPublishedHotel extends Notification
{
    use Queueable;

    /**
     * Where created user
     *
     * @var Hotel
     */
    private Hotel $hotel;

    /**
     * Create a new notification instance.
     *
     * @param  Hotel  $hotel
     * @return void
     */
    public function __construct(Hotel $hotel)
    {
        $this->hotel = $hotel;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
          ->greeting('Привет!')
          ->subject('Ваш отель не прошёл проверку на сервисе Gorooms')
          ->line('Сотрудники сервиса проверили Ваш отель "'.$this->hotel->name.'" и не подтвердил изменения')
          ->line('Необходимо исправить все ошибки. Для этого авторизуйтесь в свой аккаунт и исправьте их')
          ->line('Спасибо что пользуетесь наим сервисом');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [];
    }
}
