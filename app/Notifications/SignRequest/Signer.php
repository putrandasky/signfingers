<?php

namespace App\Notifications\SignRequest;

use App;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Signer extends Notification
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

        $encrypted_filename = hash('sha256', $this->data->email . $this->data->filename . $this->data->id);

        $encrypted_content = Storage::get("requested_files/{$encrypted_filename}");
        $decrypted_content = Crypt::decryptString($encrypted_content);

        $tempNewFile = tempnam(sys_get_temp_dir(), Str::random());

        file_put_contents($tempNewFile, $decrypted_content);
        $signer = App\Signer::where('id', $this->data->signers[0]->id)->first();
        $signer->sign_status_id = 2;
        $signer->save();

        return (new MailMessage)
            ->from($url, $name)
            ->subject("Signing Request")
            ->markdown('mail.sign_request.signer', ['data' => $this->data])
            ->attach($tempNewFile, [
                'as' => $this->data->filename,
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
