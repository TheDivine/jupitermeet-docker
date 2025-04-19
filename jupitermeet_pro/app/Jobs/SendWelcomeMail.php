<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Declare properties
    public $email;
    public $username;
    public $body;

    // Constructor
    public function __construct($email, $username, $body)
    {
        $this->email = $email;
        $this->username = $username;
        $this->body = $body;
    }

    // Execute the job
    public function handle()
    {
        $welcomeEmail = new WelcomeMail($this->email, $this->username, $this->body);
        Mail::to($this->email)->queue($welcomeEmail);
    }
}
