<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GenericDashboardNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $type;
    protected $url;
    protected $icon;
    protected $color;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $type = 'info', $url = null, $icon = null, $color = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->url = $url;
        $this->icon = $icon;
        $this->color = $color;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject($this->title ?? 'Notificação')
            ->greeting('Olá, '.($notifiable->name ?? ''))
            ->line($this->message ?? 'Você recebeu uma nova notificação.');
        if ($this->url) {
            $mail->action('Ver detalhes', $this->url);
        }
        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'url' => $this->url,
            'icon' => $this->icon,
            'color' => $this->color,
        ];
    }
}
