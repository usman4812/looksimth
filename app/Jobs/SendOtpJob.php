<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $details;

    public function __construct($details)
    {
        $this->details=$details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data =$this->details;
        Mail::send('admin.emails.forget-password', ['token' => $data], function($message) use($data){
            $message->to($data['email']);
            $message->subject('Reset Password');
        });
    }
}
