<?php

namespace App\Jobs;

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
        Notification::route('mail', $this->data['email'])->notify(new Signer($this->data));
        Notification::route('mail', $this->data['requester']['email'])->notify(new Requester($this->data));

    }
}
