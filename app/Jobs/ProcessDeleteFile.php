<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessDeleteFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $encrypted_filename;
    public function __construct($encrypted_filename)
    {
        $this->encrypted_filename = $encrypted_filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $is_file_exist = Storage::disk('local')->exists("{$this->encrypted_filename}");
        // if (!$is_file_exist) {
        //     return response()->json(['status' => 'File not found', 'message' => 'The file is already deleted'], 401);
        // }
        Storage::delete("requested_files/{$this->encrypted_filename}");

    }
}
