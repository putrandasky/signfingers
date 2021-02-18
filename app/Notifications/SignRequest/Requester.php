<?php

namespace App\Notifications\SignRequest;

use App;
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
        $signer = App\Signer::where('id', $this->data->signers[0]->id)->first();

        if ($signer->sign_status_id == 3) {
            return;
        }

        $encrypted_filename = hash('sha256', $this->data->email . $this->data->filename . $this->data->id);

        $encrypted_content = Storage::get("requested_files/{$encrypted_filename}");
        $decrypted_content = Crypt::decryptString($encrypted_content);

        $tempNewFile = tempnam(sys_get_temp_dir(), Str::random());

        file_put_contents($tempNewFile, $decrypted_content);

        $url = 'no-reply@signfinger.com';
        $name = 'Signfinger';
        return (new MailMessage)
            ->from($url, $name)
            ->subject("Your Sign Request #{$this->data->stamp_id}")
            ->markdown('mail.sign_request.requester', ['data' => $this->data])
            ->attach($tempNewFile, [
                'as' => $this->data->filename . ".pdf",
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
