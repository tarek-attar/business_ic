<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;
    protected $message;
    protected $user;
    protected $chat_room;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $user, $chat_room)
    {
        $this->message = $message;
        $this->user = $user;
        $this->chat_room = $chat_room;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['database'];
        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }
    public function toDatabase($notifiable)
    {
        $body = sprintf(
            '%s send new message for you in room %s',
            $this->user->name,
            $this->chat_room->name,
        );
        return [
            'title' => 'New Message',
            'body' => $body,
            'icon' => 'icon-material-outline-group',
            //'url' => route('chat/room/' . $this->chat_room->id),
            'url' => route('chat'),
            // ('/chat/room/{roomId}/messages', [ChatController::class, 'messages']
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
    }
}
