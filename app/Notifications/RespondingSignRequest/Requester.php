<?php

namespace App\Notifications\RespondingSignRequest;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Requester extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
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
        $url = 'no-reply@signfinger.com';
        $name = 'Signfinger';
        $encrypted_signed_filename = hash('sha256', $this->data->requester->email . $this->data->requester->filename . $this->data->requester->id . '-Signed');

        $encrypted_signed_content = Storage::get("requested_files/{$encrypted_signed_filename}");
        $decrypted_signed_content = Crypt::decryptString($encrypted_signed_content);

        $tempNewFile = tempnam(sys_get_temp_dir(), Str::random());

        file_put_contents($tempNewFile, $decrypted_signed_content);

        return (new MailMessage)
            ->from($url, $name)
            ->subject("Your Document Are Signed!")
            ->markdown('mail.responding_sign_request.requester', ['data' => $this->data])
            ->attach($tempNewFile, [
                'as' => 'SIGNED ' . $this->data->requester->filename,
            ]);
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
