<?php

namespace App\Http\Controllers\Email\PasswordReset;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $MailToken;
    public $id;

    public function __construct($id, $MailToken)
    {
        $this->MailToken = $MailToken;
        $this->id = $id;
    }

    public function build()
    {
        return $this->view('emails.ResetEmail', compact(['MailToken', 'id']));
    }
}
