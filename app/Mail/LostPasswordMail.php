<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LostPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function build()
    {
        return $this->subject('Lost Password Mail')
                    ->view('users.emails.lostpassword')
                    ->with(['userId' => $this->userId]);
    }
}
