<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotificationEmail extends Notification
{
    use Queueable;

    protected $intro;
    protected $user;
    protected $body;
    protected $actionName;
    protected $actionURL;
    protected $thanks;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->intro = $content->intro;
        $this->user = $content->user;
        $this->body = $content->body;
        $this->actionName = $content->actionName;
        $this->actionURL = $content->actionURL;
        $this->thanks = $content->thanks;
        $this->subject = $content->subject;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject($this->subject)
                    ->greeting($this->intro)
                    ->line($this->user)
                    ->line($this->body)
                    ->action($this->actionName, $this->actionURL)
                    ->line($this->thanks);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
