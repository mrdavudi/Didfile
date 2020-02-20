<?php

namespace App\Http\Controllers\admin\Email;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\Request;

class SendNews extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $text;
    public $image;

    public function __construct($title, $text, $image = null)
    {
        $this->title = $title;
        $this->text = $text;
        $this->image = $image;
    }


    public function build()
    {
        return $this->view('seller.Email.SendSiteNews', compact(['title', 'text', 'image']));
    }


}
