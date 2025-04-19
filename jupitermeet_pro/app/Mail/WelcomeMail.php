<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    public $email;
    public $username;
    public $body;

    public function __construct($email, $username, $body)
    {
        $this->email = $email;
        $this->username = $username;
        $this->body = $body;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject(__('Welcome') . ' | ' . getSetting('APPLICATION_NAME'))
            ->markdown('vendor.mail.html.welcome')
            ->with([
                'username' => $this->username,
                'body' => $this->body
            ]);
    }
}
