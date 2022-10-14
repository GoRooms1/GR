<?php

namespace App\Notifications;

use App\Models\Hotel;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notify user when created Hotel
 */
class NotificationCreateHotel extends Notification
{
    use Queueable;

    /**
     * User
     *
     * @var User
     */
    private User $user;

    private string $password;

    /**
     * Create a new notification instance.
     *
     * @param  User  $user
     * @param  string  $password
     */
    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
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
        return (new MailMessage)->greeting('Здравствуйте, '.$this->user->name.'!')
          ->subject('Команда GoRooms рада видеть именно Вас в числе наших партнеров! Вместе мы создаем современный и цивилизованный рынок бронирования для почасовых отелей и иных объектов размещения!')
          ->line('Команда GoRooms рада видеть именно Вас в числе наших партнеров! Вместе мы создаем современный и цивилизованный рынок бронирования для почасовых отелей и иных объектов размещения!')
          ->line('Добро пожаловать!')
          ->line('Логин: '.$this->user->email)
          ->line('Пароль: '.$this->password)
          ->line('В личном кабинете Вы можете внести изменения в информации об отеле и номерах, ценах, изменить логин и пароль, а так же добавить других сотрудников для работы с ресурсом.');
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
