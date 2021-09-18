<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UpdateRandomPasswordUser extends Notification
{
  use Queueable;

  private User $user;
  private string $password;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct (User $user, string $password)
  {
    $this->user = $user;
    $this->password = $password;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param mixed $notifiable
   *
   * @return array
   */
  public function via ($notifiable): array
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param mixed $notifiable
   *
   * @return MailMessage
   */
  public function toMail ($notifiable): MailMessage
  {
    return (new MailMessage)
      ->greeting('Привет!')
      ->subject('Сброс пароля на сайте Gorooms')
      ->line('Для вас был сгенерирован новый пароль')
      ->line('Логин: ' . $this->user->email)
      ->line('Пароль: ' . $this->password)
      ->line('В личном кабинете сотрудников отеля Вы можете его изменить');
  }

  /**
   * Get the array representation of the notification.
   *
   * @param mixed $notifiable
   *
   * @return array
   */
  public function toArray ($notifiable): array
  {
    return [//
    ];
  }
}
