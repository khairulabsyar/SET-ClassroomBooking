<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuccessRegisterNotification extends Notification
{
    use Queueable;

    protected $teacher;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($teacher)
    {
        $this->teacher = $teacher;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) // channel to send the notification
    {
        return ['mail', 'other'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) // toMail is naming convention
    {
        // // can be created in this way
        // $mail = new MailMessage();
        // $mail->line('test')
        //     ->line('hello world');

        // return (new MailMessage)
        //     ->line('The introduction to the notification.') // text message use line
        //     ->action('Notification Action', url('/')) // action is the button with text + link
        //     ->line('Thank you for using our application!'); // another text message after the button

        // return (new MailMessage)
        //     ->subject('Congratulations!' . $this->teacher->name) // email subject (title of email)
        //     ->line('You have successfully registered')
        //     ->action('Login now', 'https://www.google.com')
        //     ->line('Best Regards!');

        return (new MailMessage)->view("page.modified_welcome", ['totalSum' => 50]);
    }

    public function toOther($notifiable) // toMail is naming convention
    {
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) // format data store inside failed_jobs table when notifcation fail
    {
        return [
            //
        ];
    }
}
