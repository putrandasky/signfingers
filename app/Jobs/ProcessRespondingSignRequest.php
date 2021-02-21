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
use Illuminate\Support\Facades\Storage;

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
        $encrypted_filename = hash('sha256', $this->data['requester']['email'] . $this->data['requester']['filename'] . $this->data['requester']['id'] . '-Signed');
        $encrypted_unsigned_filename = hash('sha256', $this->data['requester']['email'] . $this->data['requester']['filename'] . $this->data['requester']['id']);
        Notification::route('mail', $this->data['email'])->notify(new Signer($this->data));
        Notification::route('mail', $this->data['requester']['email'])->notify(new Requester($this->data));
        dispatch(new ProcessDeleteFIle($encrypted_filename))->delay(now()->addMinutes(15));
        Storage::delete("requested_files/{$encrypted_unsigned_filename}");
    }
}
