<?php

namespace App\Http\Controllers\Email\AccountConfirm;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\Request;

class ConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $confirmationCodeForEmail;
    public $id;

    public function __construct($confirmationCodeForEmail, $id)
    {
        $this->confirmationCodeForEmail = $confirmationCodeForEmail;
        $this->id = $id;
    }


    public function build()
    {
        return $this->view('emails.registerConfirmation', compact(['confirmationCodeForEmail', 'id']));
    }
}
