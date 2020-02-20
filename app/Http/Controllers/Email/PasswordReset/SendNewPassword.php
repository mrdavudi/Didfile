<?php

namespace App\Http\Controllers\Email\PasswordReset;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewPassword extends Mailable
{
    use SerializesModels, Queueable;


    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function build()
    {
        return $this->view('emails.SendNewPassword', compact('password'));
    }
}
