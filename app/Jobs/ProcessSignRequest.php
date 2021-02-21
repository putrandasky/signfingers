<?php

namespace App\Jobs;

use App\Jobs\ProcessDeleteFile;
use App\Notifications\SignRequest\Requester;
use App\Notifications\SignRequest\Signer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ProcessSignRequest implements ShouldQueue
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
        $encrypted_filename = hash('sha256', $this->data['email'] . $this->data['filename'] . $this->data['id']);

        Notification::route('mail', $this->data['email'])->notify(new Requester($this->data));
        Notification::route('mail', $this->data['signers'][0]['email'])->notify(new Signer($this->data));
        dispatch(new ProcessDeleteFIle($encrypted_filename))->delay(now()->addHours(12));
    }
}
