<?php

namespace App\Jobs;

use App\Jobs\ProcessDeleteFile;
use App\Notifications\RespondingSignRequest\Requester;
use App\Notifications\RespondingSignRequest\Signer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ProcessRespondingSignRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $encrypted_signed_filename = hash('sha256', $this->data['requester']['email'] . $this->data['requester']['filename'] . $this->data['requester']['id'] . '-Signed');
        Notification::route('mail', $this->data['email'])->notify(new Signer($this->data));
        Notification::route('mail', $this->data['requester']['email'])->notify(new Requester($this->data));
        dispatch(new ProcessDeleteFIle($encrypted_signed_filename))->delay(now()->addMinutes(30));

    }
}
